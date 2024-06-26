@extends('layout')
@section('content')
    <x-card class="p-10 max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Create a Note
            </h2>
            <p class="mb-4">Post a new Note and Keep tracking your daily progress</p>
        </header>

        <form action="{{ route('storeNotes') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-6">
                <label for="title" class="inline-block text-lg mb-2">Note Title</label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="title"
                    value="{{ old('title') }}" placeholder="Example: Homework ... " />
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="content" class="inline-block text-lg mb-2">
                    Note Description
                </label>
                <textarea class="border border-gray-200 rounded p-2 w-full" name="content" rows="10"
                    placeholder="Include tasks, requirements, etc">
                        {{ old('content') }}</textarea>
                @error('content')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>



            <div class="mb-6">
                <button class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
                    Create Note
                </button>

                <a href="{{ route('home') }}" class="text-black ml-4"> Back </a>
            </div>
        </form>
    </x-card>
@endsection
