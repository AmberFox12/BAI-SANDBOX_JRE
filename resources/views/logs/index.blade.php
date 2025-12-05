@extends('layouts.app')

@section('content')

    <div class="max-w-5xl mx-auto space-y-6">

        <h1 class="text-2xl font-bold">Action Logs</h1>

        <table class="w-full text-sm border-collapse">
            <thead>
            <tr class="bg-gray-100">
                <th class="border px-2 py-1">Date</th>
                <th class="border px-2 py-1">User</th>
                <th class="border px-2 py-1">Action</th>
                <th class="border px-2 py-1">Idea</th>
                <th class="border px-2 py-1">Comment</th>
                <th class="border px-2 py-1">IP</th>
            </tr>
            </thead>

            <tbody>

            @foreach($logs as $log)
                <tr>
                    <td class="border px-2 py-1">{{ $log->created_at }}</td>
                    <td class="border px-2 py-1">{{ $log->user?->name ?? 'Guest' }}</td>
                    <td class="border px-2 py-1">{{ $log->action }}</td>
                    <td class="border px-2 py-1">{{ $log->idea_id ?? '-' }}</td>
                    <td class="border px-2 py-1">{{ $log->comment_id ?? '-' }}</td>
                    <td class="border px-2 py-1">{{ $log->ip_address ?? '-' }}</td>
                </tr>
            @endforeach

            </tbody>
        </table>

    </div>

@endsection
