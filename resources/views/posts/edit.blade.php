<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">Éditer : {{ $post->title }}</h2></x-slot>
    <div class="py-6 max-w-3xl mx-auto bg-white p-6 rounded shadow">
        <form action="{{ route('posts.update', $post) }}" method="POST">
            @method('PUT')
            @include('posts._form')
        </form>
    </div>
</x-app-layout>