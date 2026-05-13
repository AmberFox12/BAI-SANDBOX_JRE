@extends('layouts.app')

@section('content')

    <div class="max-w-4xl mx-auto space-y-8">

        {{-- Status / error messages --}}
        @if(session('status'))
            <div class="p-2 bg-green-100 border rounded">
                {{ session('status') }}
            </div>
        @endif
        @if(session('error'))
            <div class="p-2 bg-red-100 border rounded text-red-700">
                {{ session('error') }}
            </div>
        @endif

        {{-- Idea card --}}
        <div class="p-4 bg-white border rounded">

            <h1 class="text-2xl font-bold">{{ $idea->title }}</h1>

            <p class="text-gray-600 text-sm">
                By {{ $idea->user?->name ?? 'Unknown' }}
                • {{ $idea->created_at->toDayDateTimeString() }}
            </p>

            <p class="text-sm text-gray-600">
                Application: {{ $idea->application ?? 'N/A' }}
            </p>

            <div class="mt-4 text-sm">
                {!! nl2br(e($idea->description)) !!}
            </div>

            {{-- Edit / Delete --}}
            @if ($idea->user_id == Auth::id() || Auth::user()->is_admin)
                <div class="mt-4 flex space-x-3">
                    <a href="{{ route('ideas.edit', $idea) }}"
                    class="text-blue-600">Edit</a>

                    <form action="{{ route('ideas.destroy', $idea) }}"
                        method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600">Delete</button>
                    </form>
                </div>
            @endif
        </div>

        {{-- Add a comment --}}
        <div class="p-4 bg-white border rounded">
            <h2 class="text-xl font-semibold mb-2">Add a Comment</h2>

            @error('description')
                <p class="text-red-600 text-sm mb-2">{{ $message }}</p>
            @enderror

            <form action="{{ route('comments.store', $idea) }}" method="POST">
                @csrf

                <textarea name="description"
                          rows="3"
                          class="w-full border rounded p-2"></textarea>

                <button class="mt-2 px-4 py-2 bg-blue-600 text-white rounded">
                    Post Comment
                </button>
            </form>
        </div>

        {{-- Comments --}}
        <div class="p-4 bg-white border rounded">
            <h2 class="text-xl font-semibold mb-2">Comments</h2>

            @forelse($idea->comments as $comment)

                <div class="border-b py-2">

                    <p class="text-sm text-gray-600">
                        {{ $comment->user?->name ?? 'Unknown' }}
                        • {{ $comment->created_at->diffForHumans() }}
                    </p>

                    @if($editCommentId === $comment->id && ($comment->user_id == Auth::id() || Auth::user()->is_admin))
                        {{-- Inline edit form --}}
                        <form action="{{ route('comments.update', [$idea, $comment]) }}" method="POST" class="mt-1">
                            @csrf
                            @method('PUT')
                            <textarea name="description" rows="2"
                                      class="w-full border rounded p-2 text-sm">{{ $comment->description }}</textarea>
                            <div class="flex gap-3 mt-1">
                                <button type="submit" class="text-xs text-blue-600">Enregistrer</button>
                                <a href="{{ route('ideas.show', $idea) }}" class="text-xs text-gray-500">Annuler</a>
                            </div>
                        </form>
                    @else
                        <div class="mt-1 text-sm">
                            {!! nl2br(e($comment->description)) !!}
                        </div>

                        @if ($comment->user_id == Auth::id() || Auth::user()->is_admin)
                            <div class="flex gap-3 mt-1">
                                <a href="{{ route('ideas.show', $idea) }}?edit_comment={{ $comment->id }}"
                                   class="text-xs text-blue-600">Edit</a>

                                <form action="{{ route('comments.destroy', [$idea, $comment]) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-xs text-red-600">Delete</button>
                                </form>
                            </div>
                        @endif
                    @endif

                </div>

            @empty
                <p>No comments yet.</p>
            @endforelse

        </div>

    </div>

@endsection