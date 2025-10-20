@csrf
<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium">Titre</label>
        <input type="text" name="title" class="mt-1 w-full border rounded p-2"
               value="{{ old('title', $post->title ?? '') }}" required>
        @error('title') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium">Contenu</label>
        <textarea name="body" rows="8" class="mt-1 w-full border rounded p-2" required>{{ old('body', $post->body ?? '') }}</textarea>
        @error('body') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-4">
    <button class="px-4 py-2 bg-indigo-600 text-white rounded">Enregistrer</button>
</div>