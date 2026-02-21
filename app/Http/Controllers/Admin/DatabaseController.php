<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatabaseController extends Controller
{
    private function databaseConsoleEnabled(): bool
    {
        return app()->environment(['local', 'testing']) || (bool) config('app.admin_database_console_enabled', false);
    }

    public function index()
    {
        abort_unless($this->databaseConsoleEnabled(), 403, 'Database console is disabled in this environment.');

        $tables = DB::select('SHOW TABLES');
        return view('admin.database.index', compact('tables'));
    }

    public function executeQuery(Request $request)
    {
        abort_unless($this->databaseConsoleEnabled(), 403, 'Database console is disabled in this environment.');

        $validated = $request->validate([
            'query' => ['required', 'string', 'max:5000'],
        ]);

        $query = trim($validated['query']);

        if (! preg_match('/^(select|show|describe|explain)\s/i', $query) || str_contains($query, ';')) {
            return back()->with('error', 'Only single read-only queries are allowed.');
        }

        try {
            $results = DB::select($query);
        } catch (\Throwable $exception) {
            return back()->with('error', 'Query execution failed.');
        }

        return back()->with(['results' => $results, 'query' => $query]);
    }
}
