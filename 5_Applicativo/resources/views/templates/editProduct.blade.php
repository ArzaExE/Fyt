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
            <div id="sizes-container">
            @foreach($sizes as $index => $size)
                    <!-- Template per una riga taglia/quantità -->
                    <div class="size-row flex items-center gap-3 mb-2">
                        <select name="size_quantity[{{$index}}}][size]" class="block mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="{{number_format($size->size, 1)}}">{{number_format($size->size, 1)}}</option>
                            @for($i = 35; $i <= 50; $i += 0.5)
                                <option value="{{ number_format($i, 1) }}">{{ number_format($i, 1) }}</option>
                            @endfor
                        </select>
                        <x-text-input type="number" value="{{$size->stock}}" name="size_quantity[{{$index}}}][quantity]" min="1" class="block mt-1" placeholder="Quantity" required />
                        <button type="button" class="remove-size text-red-500 hover:text-red-700">×</button>
                    </div>
            @endforeach
            </div>

            <button type="button" id="add-size" class="mt-2 text-sm text-blue-500 hover:text-blue-700">
                + Add another size
            </button>

            <x-input-error :messages="$errors->get('size_quantity')" class="mt-2" />
            @error('size_quantity.*.quantity')
            <x-input-error :messages="$message" class="mt-2" />
            @enderror
            @error('size_quantity.*.size')
            <x-input-error :messages="$message" class="mt-2" />
            @enderror

        </div>

        <!-- Campo Highlighted -->
        <div class="mb-4">
            <x-input-label for="highlighted" :value="__('Highlighted')" />
            <input id="highlighted" class="block mt-1" type="checkbox" name="highlighted" {{ $product->highlighted ? 'checked' : '' }}/>
            <x-input-error :messages="$errors->get('highlighted')" class="mt-2" />
        </div>

        <!-- Sezione Immagini -->
        <h2 class="text-lg font-medium text-gray-900">Images Management</h2>
        <p class="mt-1 text-sm text-gray-600">Update your product images</p>

        <!-- Current Main Image -->
        <div class="mt-4">
            <x-input-label :value="__('Current Main Image')" />
            <div class="mt-2 flex items-center space-x-4">
                <img src="{{ file_exists(public_path('productImages' . $main->image)) ? asset('productImages' . $main->image) : asset('img/not_found.png') }}" class="fixed-size-img">
                <input type="hidden" name="old_main_image" value="{{ $main->image }}">
                <input type="hidden" name="old_main_id" value="{{ $main->id }}">
                <div class="ml-12">
                    <x-input-label for="mainImage" :value="__('New Main Image')" />
                    <input id="mainImage" class="block mt-1 w-full" type="file" name="mainImage" accept="image/png, image/jpeg, image/jpg, image/gif" />
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
                        <img src="{{ file_exists(public_path('productImages' . $main->image)) ? asset('productImages' . $main->image) : asset('img/not_found.png') }}" class="fixed-size-img mb-1">
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
            <input id="images" class="block mt-1 w-full" type="file" name="images[]" accept="image/png, image/jpeg, image/jpg, image/gif" multiple/>
            @error('images')
            <x-input-error :messages="$message" class="mt-2" />
            @enderror


            <!-- Non fa vedere l'errore -->
            @if (session('error'))
                <div class="mb-4 font-medium text-red-600">
                    {{ session('error') }}
                </div>
            @endif

            @error('images.*')
            <x-input-error :messages="$message" class="mt-2" />
            @enderror
            <p class="mt-1 text-sm text-gray-500">You can upload up to 10 additional images</p>
        </div>

        <div class="flex items-center justify-end mt-6 mb-6">
            <x-primary-button>
                {{ __('Edit') }}
            </x-primary-button>
        </div>
    </form>
</div>

@include('templates.footer')

<script>
    //Aspetta che il DOM sia completamente caricato prima di eseguire lo script
    document.addEventListener('DOMContentLoaded', function() {
        const sizesContainer = document.getElementById('sizes-container');
        const addSizeButton = document.getElementById('add-size');

        // Inizia il conteggio dal numero di taglie esistenti
        let rowCount = {{ count($sizes) }};

        sizesContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-size')) {
                e.target.closest('.size-row').remove();
                // Non è necessario decrementare rowCount perché gli indici esistenti rimangono
            }
        });

        addSizeButton.addEventListener('click', function() {
            const newRow = document.createElement('div');
            newRow.className = 'size-row flex items-center gap-3 mb-2';
            newRow.innerHTML = `
            <select name="size_quantity[${rowCount}][size]" class="block mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                <option value="">Select size</option>
                ${generateSizeOptions()}
            </select>
            <x-text-input type="number" name="size_quantity[${rowCount}][quantity]" min="1" class="block mt-1" placeholder="Quantity" required />
            <button type="button" class="remove-size text-red-500 hover:text-red-700">×</button>
        `;
            sizesContainer.appendChild(newRow);
            rowCount++;
        });

        function generateSizeOptions() {
            let options = '';
            for (let size = 35; size <= 50; size += 0.5) {
                options += `<option value="${size.toFixed(1)}">${size.toFixed(1)}</option>`;
            }
            return options;
        }
    });
</script>

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

