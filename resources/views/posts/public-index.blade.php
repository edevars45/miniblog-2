{{-- resources/views/posts/public-index.blade.php --}}
<x-guest-layout>
    <div class="max-w-3xl mx-auto py-8 space-y-6">
        <h1 class="text-2xl font-bold">MiniBlog — Articles publiés</h1>

        @forelse ($posts as $post)
            <article class="border rounded-lg p-4">
                 {{-- Lier les titres sur la liste publique --}}
                <h2 class="text-xl font-semibold">
                    {{-- lien vers la page détail par SLUG --}}
                    <a href="{{ route('posts.public.show', $post) }}" class="underline">
                        {{ $post->title }}
                    </a>
                </h2>

                <p class="text-sm text-gray-500">
                    Publié le {{ optional($post->published_at)->format('d/m/Y') }}
                    par {{ $post->user->name }}
                </p>

                <p class="mt-2">
                    {{ \Illuminate\Support\Str::of(strip_tags($post->body))->limit(200) }}
                </p>
            </article>
        @empty
            <p>Aucun article publié pour le moment.</p>
        @endforelse

      {{ $posts->links() }}
    </div>
</x-guest-layout>
