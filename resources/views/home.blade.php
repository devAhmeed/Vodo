@extends('layout')

@section('content')
    @include('partials._hero')
    <div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">
        @auth
        @php
            $notes = auth()->user()->notes()->get();
            
        @endphp
        @foreach ($notes as $note)
            <x-note-card :note="$note" />
        @endforeach
        @endauth

    </div>
    <div class="mt-6 p-4">
    </div>
@endsection
