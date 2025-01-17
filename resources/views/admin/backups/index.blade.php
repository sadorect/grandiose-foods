@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Database Backups</h2>
            <form action="{{ route('admin.backups.create') }}" method="POST">
                @csrf
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                    Create New Backup
                </button>
            </form>
        </div>

        <div class="bg-white shadow rounded-lg">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b">Filename</th>
                        <th class="px-6 py-3 border-b">Size</th>
                        <th class="px-6 py-3 border-b">Created At</th>
                        <th class="px-6 py-3 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($backups as $backup)
                  <tr>
                      <td class="px-6 py-4">{{ $backup['filename'] }}</td>
                      <td class="px-6 py-4">{{ round($backup['size'] / 1024 / 1024, 2) }} MB</td>
                      <td class="px-6 py-4">{{ date('Y-m-d H:i:s', $backup['created_at']) }}</td>
                      <td class="px-6 py-4">
                          <a href="{{ route('admin.backups.download', $backup['filename']) }}" 
                             class="text-blue-500 hover:underline mr-3">Download</a>
                          <form class="inline" method="POST" 
                                action="{{ route('admin.backups.delete', $backup['filename']) }}">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="text-red-500 hover:underline">Delete</button>
                          </form>
                      </td>
                  </tr>
              @endforeach
              
                </tbody>
            </table>
            <div class="mt-8 p-4 bg-gray-50 rounded">
              <h3 class="font-bold mb-4">Restore Instructions:</h3>
              <ol class="list-decimal ml-4">
                  <li>Download the backup file</li>
                  <li>Extract the zip archive</li>
                  <li>Import the database using the SQL dump</li>
                  <li>Copy the files back to their respective directories</li>
              </ol>
          </div>
          
        </div>
    </div>
    @endsection
