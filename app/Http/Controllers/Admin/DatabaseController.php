<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatabaseController extends Controller
{
    public function index()
    {
        $tables = DB::select('SHOW TABLES');
        return view('admin.database.index', compact('tables'));
    }

    public function executeQuery(Request $request)
    {
        $query = $request->input('query');
        $results = DB::select($query);
        return back()->with(['results' => $results, 'query' => $query]);
    }
}
