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
  

public function index()
{
  $backupPath = 'Grandiose Foods';
    $backups = collect(Storage::files($backupPath))
        ->map(function ($file) {
            return [
                'filename' => basename($file),
                'size' => Storage::size($file),
                'created_at' => Storage::lastModified($file)
            ];
        })
        ->sortByDesc('created_at');
       
    return view('admin.backups.index', compact('backups'));
}

  

    public function create()
{
    try {
        // Force the backup process to run in foreground
        Log::info('Starting backup process...');
        $output = Artisan::call('backup:run', [
            '--only-db' => true,
            '--disable-notifications' => true
        ]);
        Log::info('Backup completed');
        Log::info(Artisan::output());
        
        return redirect()->back()->with([
            'success' => 'Backup created successfully',
            'output' => Artisan::output()
        ]);
    } catch (\Exception $e) {
        Log::error('Backup failed: ' . $e->getMessage());
        return redirect()->back()->with('error', $e->getMessage());
    }
}

    

public function download($fileName)
{
    $path = storage_path("app/Grandiose Foods/{$fileName}");
    return response()->download($path);
}


    public function delete($fileName)
    {
        Storage::delete("backups/{$fileName}");
        return redirect()->back()->with('success', 'Backup deleted successfully');
    }

    public function restore(Request $request)
{
    $fileName = $request->backup_file;
    Artisan::call('backup:restore', ['filename' => $fileName]);
    return redirect()->back()->with('success', 'System restored successfully');
}

}
