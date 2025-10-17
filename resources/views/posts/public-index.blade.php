<x-guest-layout>
    <div class="max-w-3xl mx-auto py-8 space-y-6">
        <h1 class="text-2xl font-bold">MiniBlog — Articles publiés</h1>

        @foreach ($posts as $post)
            <article class="border rounded-lg p-4">
                <h2 class="text-xl font-semibold">{{ $post->title }}</h2>
                <p class="text-sm text-gray-500">
                    Publié le {{ optional($post->published_at)->format('d/m/Y') }}
                    par {{ $post->user->name }}
                </p>
                <p class="mt-2">
                    {{ str(strip_tags($post->body))->limit(200) }}
                </p>
            </article>
        @endforeach

        {{ $posts->links() }}
    </div>
</x-guest-layout>