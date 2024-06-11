@props(['note'])
<!-- Item 1 -->
<x-card>
    <div class="flex">
        <img class="hidden w-48 mr-6 md:block"
            src="{{ $note->logo ? asset('storage/' . $note->logo) : asset('images/logo.png') }}" alt="" />
        <div>
            <h3 class="text-2xl">
                <a href="{{route('home')}}">{{ $note->title }}</a>
            </h3>
            <div class="text-xl font-bold mb-4">{{ $note->content }}</div>
        </div>
    </div>
</x-card>
