
<!-- Form per l'aggiunta del prodotto -->
<form method="POST" action="{{ route('vendor.upload') }}" enctype="multipart/form-data">
    @csrf

    <!-- Campo Name -->
    <div class="mb-4">
        <x-input-label for="name" :value="__('Name')" />
        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <!-- Campo Color -->
    <div class="mb-4">
        <x-input-label for="color" :value="__('Color')" />
        <x-text-input id="color" class="block mt-1 w-full" type="text" name="color" :value="old('color')" required />
        <x-input-error :messages="$errors->get('color')" class="mt-2" />
    </div>

    <!-- Campo Description -->
    <div class="mb-4">
        <x-input-label for="description" :value="__('Description')" />
        <textarea id="description" name="description" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="4" required>{{ old('description') }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>

    <!-- Campo Release Date -->
    <div class="mb-4 w-full">
        <x-input-label for="release_date" :value="__('Release Date')" />
        <x-text-input id="release_date" class="block mt-1 w-full" type="date" name="release_date" :value="old('release_date')" required />
        <x-input-error :messages="$errors->get('release_date')" class="mt-2" />
    </div>

    <!-- Campo Price -->
    <div class="mb-4">
        <x-input-label for="price" :value="__('Price (€)')" />
        <x-text-input id="price" class="block mt-1 w-full" type="number" step="0.01" name="price" :value="old('price')" required />
        <x-input-error :messages="$errors->get('price')" class="mt-2" />
    </div>

    <!-- Campo Images -->
    <div class="mb-4">
        <x-input-label for="images" :value="__('Images')" />
        <input id="images" class="block mt-1 w-full" type="file" name="images[]" accept="image/*" required multiple/>
        <x-input-error :messages="$errors->get('image')" class="mt-2" />
    </div>

    <!-- Pulsante di invio -->
    <div class="flex items-center justify-end mt-6">
        <x-primary-button>
            {{ __('Add product') }}
        </x-primary-button>
    </div>
</form>

