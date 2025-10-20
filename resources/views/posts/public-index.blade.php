{{-- J’utilise le layout invité (sans barre d’auth), fourni par Breeze --}}
<x-guest-layout>
    {{-- Je centre le contenu, je limite la largeur, et j’ajoute de l’espace vertical entre les blocs --}}
    <div class="max-w-3xl mx-auto py-8 space-y-6">
        {{-- Je mets un titre de page clair pour la liste publique des articles --}}
        <h1 class="text-2xl font-bold">MiniBlog — Articles publiés</h1>

        {{-- Je parcours la collection paginée $posts que mon contrôleur m’a envoyée --}}
        @foreach ($posts as $post)
            {{-- Pour chaque article, je crée une carte simple avec bordure et arrondis --}}
            <article class="border rounded-lg p-4">
                {{-- J’affiche le titre de l’article de façon proéminente --}}
                <h2 class="text-xl font-semibold">{{ $post->title }}</h2>

                {{-- J’affiche la date de publication (si elle existe) et le nom de l’auteur --}}
                <p class="text-sm text-gray-500">
                    {{-- optional() me permet d’appeler format() même si published_at est null --}}
                    Publié le {{ optional($post->published_at)->format('d/m/Y') }}
                    {{-- Je récupère le nom de l’auteur via la relation user préchargée par with('user') --}}
                    par {{ $post->user->name }}
                </p>

                {{-- J’affiche un extrait du contenu en supprimant le HTML et en limitant la longueur --}}
                <p class="mt-2">
                    {{-- strip_tags retire les balises HTML ; str(...)->limit(200) limite à 200 caractères --}}
                    {{ str(strip_tags($post->body))->limit(200) }}
                </p>
            </article>
        @endforeach

        {{-- J’affiche la pagination générée par Laravel sur la collection $posts --}}
        {{ $posts->links() }}
    </div>
</x-guest-layout>
