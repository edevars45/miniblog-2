<x-guest-layout>
    <div class="max-w-3xl mx-auto py-8 space-y-3">
        <h1 class="text-3xl font-bold">{{ $post->title }}</h1>
        <p class="text-sm text-gray-500">
            @if($post->published_at)
                Publié le {{ $post->published_at->format('d/m/Y') }}
            @else
                <span class="italic">Non publié</span>
            @endif
            — par {{ $post->user->name }}
        </p>

        <div class="prose max-w-none">
            {!! nl2br(e($post->body)) !!}
        </div>

        <p class="mt-6">
            <a href="{{ route('home') }}" class="underline text-indigo-600">← Retour à la liste</a>
        </p>
    </div>
</x-guest-layout>