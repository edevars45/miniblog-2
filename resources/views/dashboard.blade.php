<x-app-layout>
    {{-- =======================
         En-tête du dashboard
       ======================= --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- =======================
         Contenu principal
       ======================= --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Message standard quand l'utilisateur est connecté --}}
                    {{ __("You're logged in!") }}

                    {{-- Zone visible UNIQUEMENT aux utilisateurs ayant le rôle "admin" --}}
                    @role('admin')
                        <a href="{{ route('admin.home') }}" class="underline text-indigo-600">
                            Aller à l’espace admin
                        </a>
                    @endrole

                    {{-- Zone visible aux utilisateurs ayant la permission fine "posts.publish" --}}
                    @can('posts.publish')
                        <p>Vous pouvez publier des articles.</p>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
