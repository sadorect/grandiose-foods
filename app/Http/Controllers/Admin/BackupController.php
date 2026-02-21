<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Spatie\Backup\Tasks\Backup\BackupJob;

class BackupController extends Controller
{
    private function backupDirectory(): string
    {
        return (string) config('backup.backup.name', 'Grandiose Foods');
    }

    private function sanitizeFileName(string $fileName): ?string
    {
        $safeName = basename($fileName);

        if ($safeName === '' || $safeName !== $fileName || str_contains($safeName, '..')) {
            return null;
        }

        return $safeName;
    }

    private function resolveBackupPath(string $fileName): ?string
    {
        $safeName = $this->sanitizeFileName($fileName);

        if (! $safeName) {
            return null;
        }

        $relativePath = $this->backupDirectory().'/'.$safeName;

        if (! Storage::disk('local')->exists($relativePath)) {
            return null;
        }

        return $relativePath;
    }
  

public function index()
{
    $backupPath = $this->backupDirectory();

    $backups = collect(Storage::disk('local')->files($backupPath))
        ->map(function ($file) {
            return [
                'filename' => basename($file),
                'size' => Storage::disk('local')->size($file),
                'created_at' => Storage::disk('local')->lastModified($file),
            ];
        })
        ->sortByDesc('created_at');
       
    return view('admin.backups.index', compact('backups'));
}

  

    public function create()
{
    try {
        Log::info('Starting backup process...');
            $exitCode = Artisan::call('backup:run', [
            '--only-db' => true,
            '--disable-notifications' => true
        ]);

            $commandOutput = trim(Artisan::output());

            if ($exitCode !== 0) {
                Log::error('Backup command failed', [
                    'exit_code' => $exitCode,
                    'output' => $commandOutput,
                ]);

                return redirect()->back()->with('error', 'Backup failed. Please check server logs for details.');
            }

            Log::info('Backup completed', ['output' => $commandOutput]);
        
        return redirect()->back()->with([
            'success' => 'Backup created successfully',
                'output' => $commandOutput
        ]);
    } catch (\Exception $e) {
        Log::error('Backup failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Backup failed. Please check server logs for details.');
    }
}

    

public function download($fileName)
{
    $path = $this->resolveBackupPath($fileName);

    abort_unless($path, 404);

    return response()->download(storage_path('app/'.$path));
}


    public function delete($fileName)
    {
        $path = $this->resolveBackupPath($fileName);

        abort_unless($path, 404);

        Storage::disk('local')->delete($path);

        return redirect()->back()->with('success', 'Backup deleted successfully');
    }

    public function restore($fileName)
{
    $path = $this->resolveBackupPath($fileName);

    abort_unless($path, 404);

    Artisan::call('backup:restore', ['filename' => basename($path)]);

    return redirect()->back()->with('success', 'System restored successfully');
}

}
