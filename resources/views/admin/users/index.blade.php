<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Gestion des rôles — Utilisateurs</h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto space-y-4">
        @if (session('status'))
            <div class="p-3 bg-green-100 rounded">{{ session('status') }}</div>
        @endif

        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2">Nom</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Rôles</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $user->name }}</td>
                        <td class="px-4 py-2">{{ $user->email }}</td>
                        <td class="px-4 py-2">
                            @forelse ($user->roles as $role)
                                <span class="inline-block px-2 py-1 bg-indigo-100 text-indigo-800 rounded text-sm">{{ $role->name }}</span>
                            @empty
                                <span class="text-gray-500">Aucun</span>
                            @endforelse
                        </td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.users.roles.edit', $user) }}" class="underline text-indigo-600">Gérer les rôles</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{ $users->links() }}
    </div>
</x-app-layout>