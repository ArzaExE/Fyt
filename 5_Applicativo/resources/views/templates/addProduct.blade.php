@include('templates.header')
<div class="container mt-5">
    <!-- Form per l'aggiunta del prodotto -->
    <form method="POST" action="{{ route('vendor.upload') }}" enctype="multipart/form-data">
        @csrf

        @if(session('failed'))
            <div class="alert alert-danger">
                {{ session('failed') }}
            </div>
        @endif

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
            <x-text-input id="price" class="block mt-1 w-full" type="number" min="0" step="0.01" name="price" :value="old('price')" required />
            <x-input-error :messages="$errors->get('price')" class="mt-2" />
        </div>

        <!-- Campo Taglie e Quantità -->
        <div class="mb-4">
            <x-input-label :value="__('Available Sizes and Quantities')" />

            <div id="sizes-container">
                <!-- Template per una riga taglia/quantità -->
                <div class="size-row flex items-center gap-3 mb-2">
                    <select name="size_quantity[0][size]" class="block mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="">Select size</option>
                        @for($i = 35; $i <= 50; $i += 0.5)
                            <option value="{{ number_format($i, 1) }}">{{ number_format($i, 1) }}</option>
                        @endfor
                    </select>
                    <x-text-input type="number" name="size_quantity[0][quantity]" min="1" class="block mt-1" placeholder="Quantity" required />
                    <button type="button" class="remove-size text-red-500 hover:text-red-700">×</button>
                </div>
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
        <div class="mt-4">
            <x-input-label for="highlighted" :value="__('Highlighted')" />
            <input id="highlighted" class="block mt-1" type="checkbox" name="highlighted" value="1" {{ old('highlighted') ? 'checked' : '' }}/>
            <x-input-error :messages="$errors->get('highlighted')" class="mt-2" />
        </div>


        <!-- Campo Images -->

        <!-- Immagine principale -->
        <div class="mb-4">
            <x-input-label for="mainImage" :value="__('Main image')" />
            <input id="mainImage" class="block mt-1 w-full" type="file" name="mainImage" accept="image/png, image/jpeg, image/jpg, image/gif" required/>
            <x-input-error :messages="$errors->get('mainImage')" class="mt-2" />
        </div>

        <!-- Immagini multiple -->
        <div class="mb-4">
            <x-input-label for="images" :value="__('Other images')" />
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
        </div>

        <!-- Pulsante di invio -->
        <div class="flex items-center justify-end mt-6">
            <x-primary-button>
                {{ __('Add product') }}
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
        let rowCount = 1;

        // Aggiunge un listener che gestisce tutti i click sui pulsanti ×
        sizesContainer.addEventListener('click', function(e) {
            // Verifica se l'elemento cliccato (e.target) ha la classe 'remove-size'
            if (e.target.classList.contains('remove-size')) {
                // Se sì, trova la riga (.size-row) più vicina e la rimuove dal DOM
                e.target.closest('.size-row').remove();
            }
        });

        // Aggiungi un listener al pulsante "Aggiungi taglia"
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
            // Aggiunge la nuova riga al contenitore
            sizesContainer.appendChild(newRow);
            rowCount++;
        });


        // Funzione che genera le opzioni delle taglie da 35 a 50 con incrementi di 0.5
        function generateSizeOptions() {
            let options = '';
            for (let size = 35; size <= 50; size += 0.5) {
                // toFixed(1) --> formatta il numero con un numero dopo la virgola p.es 36 --> 36.0
                options += `<option value="${size.toFixed(1)}">${size.toFixed(1)}</option>`;
            }
            return options;
        }
    });
</script>
