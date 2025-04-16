@include('templates.header')
<div class="container mt-5">
    <b><h1 style="font-size: 25px">Edit {{$product->name}}</h1></b>
    <br>
    <br>
    <form method="POST" action="{{ route('vendor.save', $product) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Campo Name -->
        <div class="mb-4">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name', $product->name) }}" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Campo Color -->
        <div class="mb-4">
            <x-input-label for="color" :value="__('Color')" />
            <x-text-input id="color" class="block mt-1 w-full" type="text" name="color" value="{{ old('color', $product->color) }}" required />
            <x-input-error :messages="$errors->get('color')" class="mt-2" />
        </div>

        <!-- Campo Description -->
        <div class="mb-4">
            <x-input-label for="description" :value="__('Description')" />
            <textarea id="description" name="description" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="4" required>{{ old('description', $product->description) }}</textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <!-- Campo Release Date -->
        <div class="mb-4 w-full">
            <x-input-label for="release_date" :value="__('Release Date')" />
            <x-text-input id="release_date" class="block mt-1 w-full" type="date" name="release_date" value="{{ old('release_date', $product->formatted_release_date_for_form) }}" required />
            <x-input-error :messages="$errors->get('release_date')" class="mt-2" />
        </div>

        <!-- Campo Price -->
        <div class="mb-4">
            <x-input-label for="price" :value="__('Price (€)')" />
            <x-text-input id="price" class="block mt-1 w-full" type="number" min="0" step="0.01" name="price" value="{{ old('price', $product->price) }}" required />
            <x-input-error :messages="$errors->get('price')" class="mt-2" />
        </div>

        <!-- Campo Taglie e Quantità -->
        <div class="mb-4">
            <x-input-label :value="__('Available Sizes and Quantities')" />
            @foreach($sizes as $size)
                <div id="sizes-container">
                    <!-- Template per una riga taglia/quantità -->
                    <div class="size-row flex items-center gap-3 mb-2">
                        <select name="size_quantity[0][size]" class="block mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="{{number_format($size->size, 1)}}">{{number_format($size->size, 1)}}</option>
                            @for($i = 35; $i <= 50; $i += 0.5)
                                <option value="{{ number_format($i, 1) }}">{{ number_format($i, 1) }}</option>
                            @endfor
                        </select>
                        <x-text-input type="number" value="{{$size->stock}}" name="size_quantity[0][quantity]" min="1" class="block mt-1" placeholder="Quantity" required />
                        <button type="button" class="remove-size text-red-500 hover:text-red-700">×</button>
                    </div>
                </div>
            @endforeach

            <button type="button" id="add-size" class="mt-2 text-sm text-blue-500 hover:text-blue-700">
                + Add another size
            </button>

            <x-input-error :messages="$errors->get('sizes')" class="mt-2" />
            <x-input-error :messages="$errors->get('quantities')" class="mt-2" />
            <x-input-error :messages="$errors->get('sizes.*')" class="mt-2" />
            <x-input-error :messages="$errors->get('quantities.*')" class="mt-2" />
        </div>

        <!-- Sezione Immagini -->
        <h2 class="text-lg font-medium text-gray-900">Images Management</h2>
        <p class="mt-1 text-sm text-gray-600">Update your product images</p>

        <!-- Current Main Image -->
        <div class="mt-4">
            <x-input-label :value="__('Current Main Image')" />
            <div class="mt-2 flex items-center space-x-4">
                <img src="{{ asset('productImages'. $main->image) }}" alt="Current main image" class="fixed-size-img">
                <input type="hidden" name="old_main_image" value="{{ $main->image }}">
                <input type="hidden" name="old_main_id" value="{{ $main->id }}">
                <div class="ml-12">
                    <x-input-label for="mainImage" :value="__('New Main Image')" />
                    <input id="mainImage" class="block mt-1 w-full" type="file" name="mainImage" accept="image/*" />
                    <x-input-error :messages="$errors->get('mainImage')" class="mt-2" />
                    <p class="mt-1 text-sm text-gray-500">Leave empty to keep current image</p>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <x-input-label :value="__('Current Additional Images')" />
            <div class="flex flex-wrap gap-3 mt-2">
                @foreach($images as $image)
                    <div class="flex flex-col items-center border rounded p-2 w-24">
                        <img src="{{ asset('productImages'.$image->image) }}" alt="Product image" class="fixed-size-img mb-1">
                        <label class="flex items-center space-x-1">
                            <input type="checkbox"
                                   name="delete_images[]"
                                   value="{{ $image->id }}"
                                   class="rounded border-gray-300 text-red-600 shadow-sm h-4 w-4 focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50">
                            <span class="text-red-600 text-xs">Delete</span>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Add New Images -->
        <div class="mt-6">
            <x-input-label for="images" :value="__('Add More Images')" />
            <input id="images" class="block mt-1 w-full" type="file" name="images[]" accept="image/*" multiple/>
            <x-input-error :messages="$errors->get('images.*')" class="mt-2" />
            <x-input-error :messages="$errors->get('images')" class="mt-2" />
            <p class="mt-1 text-sm text-gray-500">You can upload up to 10 additional images</p>
        </div>

        <div class="flex items-center justify-end mt-6">
            <x-primary-button>
                {{ __('Edit') }}
            </x-primary-button>
        </div>
    </form>
</div>

<style>
    .fixed-size-img {
        width: 128px;
        height: 128px;
        object-fit: cover;
        object-position: center;
        border-radius: 0.5rem; /* opzionale, per arrotondare */
        flex-shrink: 0; /* evita che si restringa */
    }
</style>

