@extends('layouts.app')

@section('content')

    <div class="max-w-3xl mx-auto">

        <h1 class="text-2xl font-bold mb-4">New Idea</h1>

        <form action="{{ route('ideas.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium">Title</label>
                <input type="text" name="title"
                       class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block text-sm font-medium">Application</label>
                <input type="text" name="application"
                       class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block text-sm font-medium">Description</label>
                <textarea name="description" rows="6"
                          class="w-full border rounded p-2"></textarea>
            </div>

            <button class="px-4 py-2 bg-blue-600 text-white rounded">
                Save Idea
            </button>
        </form>

    </div>

@endsection
