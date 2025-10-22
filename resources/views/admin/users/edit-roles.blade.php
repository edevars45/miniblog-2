<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Rôles de {{ $user->name }}</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto bg-white p-6 rounded shadow space-y-4">
        <form method="POST" action="{{ route('admin.users.roles.update', $user) }}">
            @csrf
            @method('PUT')

            <div class="space-y-2">
                @foreach ($roles as $role)
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                               @checked(in_array($role->name, $userRoleNames))>
                        <span>{{ $role->name }}</span>
                    </label>
                @endforeach
            </div>

            <div class="mt-4">
                <button class="px-4 py-2 bg-indigo-600 text-white rounded">Enregistrer</button>
                <a href="{{ route('admin.users.index') }}" class="ml-3 underline">Annuler</a>
            </div>
        </form>
    </div>
</x-app-layout>