@extends('layouts.app')

@section('content')

    <div class="max-w-3xl mx-auto">

        <h1 class="text-2xl font-bold mb-4">Edit Idea</h1>

        <form action="{{ route('ideas.update', $idea) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium">Title</label>
                <input type="text" name="title"
                       value="{{ $idea->title }}"
                       class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block text-sm font-medium">Application</label>
                <input type="text" name="application"
                       value="{{ $idea->application }}"
                       class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block text-sm font-medium">Description</label>
                <textarea name="description" rows="6"
                          class="w-full border rounded p-2">{{ $idea->description }}</textarea>
            </div>

            <button class="px-4 py-2 bg-blue-600 text-white rounded">
                Update
            </button>
        </form>

    </div>

@endsection
