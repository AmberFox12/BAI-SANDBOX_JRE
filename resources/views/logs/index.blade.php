@extends('layouts.app')

@section('content')

    <div class="max-w-5xl mx-auto space-y-6">

        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Action Logs</h1>
            <form method="POST" action="{{ route('logs.purge') }}"
                  onsubmit="return confirm('Supprimer tous les logs de plus de 90 jours ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded text-sm">
                    Purger (> 90 jours)
                </button>
            </form>
        </div>

        @if(session('status'))
            <div class="p-2 bg-green-100 border rounded">{{ session('status') }}</div>
        @endif

        {{-- Filtres --}}
        <form method="GET" action="{{ route('logs.index') }}" class="flex items-end gap-4 p-4 bg-white border rounded">

            <div>
                <label class="block text-sm font-medium text-gray-700">Date</label>
                <input type="date" name="date" value="{{ request('date') }}"
                       class="mt-1 border rounded px-2 py-1 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Action</label>
                <select name="action" class="mt-1 border rounded px-2 py-1 text-sm">
                    <option value="">Toutes</option>
                    @foreach($actions as $action)
                        <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                            {{ $action }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded text-sm">
                Filtrer
            </button>

            <a href="{{ route('logs.index') }}" class="px-4 py-2 border rounded text-sm text-gray-600 inline-flex items-center">
                Reinitialiser
            </a>
        </form>

        <table class="w-full text-sm border-collapse">
            <thead>
            <tr class="bg-gray-100">
                <th class="border px-2 py-1">Date</th>
                <th class="border px-2 py-1">User</th>
                <th class="border px-2 py-1">Action</th>
                <th class="border px-2 py-1">Idea</th>
                <th class="border px-2 py-1">Comment</th>
                <th class="border px-2 py-1">IP</th>
                <th class="border px-2 py-1">Details</th>
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
                    <td class="border px-2 py-1 text-xs">{{ $log->details }}</td>
                </tr>
            @endforeach

            </tbody>
        </table>

    </div>

@endsection
