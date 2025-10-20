<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Mes articles</h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto space-y-4">
        @if (session('status'))
            <div class="p-3 bg-green-100 rounded">{{ session('status') }}</div>
        @endif

        @can('posts.create')
            <a href="{{ route('posts.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded">
                Nouvel article
            </a>
        @endcan

        <div class="overflow-x-auto bg-white rounded shadow mt-4 mb-4">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2">Titre</th>
                        <th class="px-4 py-2">Auteur</th>
                        <th class="px-4 py-2">Statut</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($posts as $post)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $post->title }}</td>
                        <td class="px-4 py-2">{{ $post->user->name }}</td>
                        <td class="px-4 py-2">
                            @if($post->status === 'published')
                                Publié @if($post->published_at) ({{ $post->published_at->format('d/m/Y') }}) @endif
                            @else
                                Brouillon
                            @endif
                        </td>
                        <td class="px-4 py-2 space-x-2">
                            @can('update', $post)
                                <a href="{{ route('posts.edit', $post) }}" class="underline text-indigo-600">Éditer</a>
                            @endcan

                            @can('delete', $post)
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Supprimer cet article ?');">
                                    @csrf @method('DELETE')
                                    <button class="underline text-red-600">Supprimer</button>
                                </form>
                            @endcan

                            @can('posts.publish')
                                @if($post->status === 'draft')
                                    <form action="{{ route('posts.publish', $post) }}" method="POST" class="inline">
                                        @csrf
                                        <button class="underline text-green-700">Publier</button>
                                    </form>
                                @else
                                    <form action="{{ route('posts.unpublish', $post) }}" method="POST" class="inline">
                                        @csrf
                                        <button class="underline text-yellow-700">Dépublier</button>
                                    </form>
                                @endif
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr><td class="px-4 py-6" colspan="4">Aucun article pour le moment.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $posts->links() }}
    </div>
</x-app-layout>