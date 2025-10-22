<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
                Tableau de bord
            </h2>

            <div class="flex items-center gap-2">
                @can('users.manage')
                    <a href="{{ route('admin.home') }}"
                        class="inline-flex items-center px-3 py-2 rounded-lg border border-gray-300 text-sm font-medium hover:bg-gray-50">
                        Espace admin
                    </a>
                @endcan

                <a href="{{ route('posts.index') }}"
                    class="inline-flex items-center px-3 py-2 rounded-lg border border-gray-300 text-sm font-medium hover:bg-gray-50">
                    Mes articles
                </a>

                @can('posts.create')
                    <a href="{{ route('posts.create') }}"
                        class="inline-flex items-center px-3 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">
                        Nouvel article
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="rounded-md bg-green-50 border border-green-200 p-3 text-sm text-green-800">
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Carte bienvenue & actions rapides -->
                <div class="md:col-span-2 bg-white rounded-xl shadow p-6">
                    <h3 class="text-lg font-semibold">Bienvenue, {{ auth()->user()->name }} 👋</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Gérez vos articles et, selon vos droits, l’administration du site.
                    </p>

                    <div class="mt-4 flex flex-wrap gap-2">
                        <a href="{{ route('posts.index') }}"
                            class="px-3 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 text-sm">
                            Voir mes articles
                        </a>
                        @can('posts.create')
                            <a href="{{ route('posts.create') }}"
                                class="px-3 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 text-sm">
                                Créer un article
                            </a>
                        @endcan
                        <!-- Carte rôles & capacités -->
                        <div class="bg-white rounded-xl shadow p-6">
                            <h3 class="text-sm font-medium text-gray-700">Mes rôles</h3>
                            <div class="mt-2 flex flex-wrap gap-2">
                                @php($roles = auth()->user()->getRoleNames())
                                @forelse ($roles as $role)
                                    <span
                                        class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium bg-indigo-100 text-indigo-800">
                                        {{ $role }}
                                    </span>
                                @empty
                                    <span class="text-gray-500 text-sm">Aucun rôle</span>
                                @endforelse
                            </div>

                            @can('posts.publish')
                                <div class="mt-4">
                                    <span
                                        class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium bg-green-100 text-green-800">
                                        Vous pouvez publier des articles
                                    </span>
                                </div>
                            @endcan
                        </div>
                        @can('users.manage')
                            <!-- Carte administration -->
                            <div class="grid grid-cols-1 gap-6">
                                <div class="bg-white rounded-xl shadow p-6">
                                    <h3 class="text-sm font-medium text-gray-700">Administration</h3>
                                    <p class="mt-1 text-sm text-gray-600">
                                        Gérer les utilisateurs.
                                    </p>
                                    <div class="mt-4 flex flex-wrap gap-2">
                                        <a href="{{ route('admin.users.index') }}"
                                            class="px-3 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 text-sm">
                                            Utilisateurs
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endcan

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
