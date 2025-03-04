@props(['product' => null, 'categories' => []])

<div class="grid grid-cols-1 gap-y-6">
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Nombre del producto</label>
        <input type="text" name="name" id="name"
            value="{{ old('name', $product?->name) }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
            required>
        @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
        <textarea name="description" id="description" rows="4"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
            required>{{ old('description', $product?->description) }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700">Precio</label>
            <div class="relative mt-1 rounded-md shadow-sm">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <span class="text-gray-500 sm:text-sm">$</span>
                </div>
                <input type="number" name="price" id="price"
                    value="{{ old('price', $product?->price) }}"
                    class="block w-full rounded-md border-gray-300 pl-7 pr-12 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    placeholder="0.00" step="0.01" min="0" required>
            </div>
            @error('price')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
            <input type="number" name="stock" id="stock"
                value="{{ old('stock', $product?->stock) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                min="0" required>
            @error('stock')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        <div>
            <label for="platform" class="block text-sm font-medium text-gray-700">Plataforma</label>
            <select name="platform" id="platform"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                required>
                <option value="">Seleccionar plataforma</option>
                <option value="PC" {{ old('platform', $product?->platform) == 'PC' ? 'selected' : '' }}>PC</option>
                <option value="PS5" {{ old('platform', $product?->platform) == 'PS5' ? 'selected' : '' }}>PlayStation 5</option>
                <option value="PS4" {{ old('platform', $product?->platform) == 'PS4' ? 'selected' : '' }}>PlayStation 4</option>
                <option value="Xbox Series X" {{ old('platform', $product?->platform) == 'Xbox Series X' ? 'selected' : '' }}>Xbox Series X</option>
                <option value="Xbox One" {{ old('platform', $product?->platform) == 'Xbox One' ? 'selected' : '' }}>Xbox One</option>
                <option value="Nintendo Switch" {{ old('platform', $product?->platform) == 'Nintendo Switch' ? 'selected' : '' }}>Nintendo Switch</option>
            </select>
            @error('platform')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700">Categoría</label>
            <select name="category_id" id="category_id"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                required>
                <option value="">Seleccionar categoría</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id', $product?->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        <div>
            <label for="publisher" class="block text-sm font-medium text-gray-700">Distribuidora</label>
            <input type="text" name="publisher" id="publisher"
                value="{{ old('publisher', $product?->publisher) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            @error('publisher')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="developer" class="block text-sm font-medium text-gray-700">Desarrolladora</label>
            <input type="text" name="developer" id="developer"
                value="{{ old('developer', $product?->developer) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            @error('developer')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        <div>
            <label for="release_date" class="block text-sm font-medium text-gray-700">Fecha de lanzamiento</label>
            <input type="date" name="release_date" id="release_date"
                value="{{ old('release_date', optional($product?->release_date)->format('Y-m-d')) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            @error('release_date')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="rating" class="block text-sm font-medium text-gray-700">Clasificación ESRB</label>
            <select name="rating" id="rating"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                <option value="">Seleccionar clasificación</option>
                <option value="E" {{ old('rating', $product?->rating) == 'E' ? 'selected' : '' }}>E (Everyone)</option>
                <option value="E10+" {{ old('rating', $product?->rating) == 'E10+' ? 'selected' : '' }}>E10+ (Everyone 10+)</option>
                <option value="T" {{ old('rating', $product?->rating) == 'T' ? 'selected' : '' }}>T (Teen)</option>
                <option value="M" {{ old('rating', $product?->rating) == 'M' ? 'selected' : '' }}>M (Mature)</option>
                <option value="AO" {{ old('rating', $product?->rating) == 'AO' ? 'selected' : '' }}>AO (Adults Only)</option>
                <option value="RP" {{ old('rating', $product?->rating) == 'RP' ? 'selected' : '' }}>RP (Rating Pending)</option>
            </select>
            @error('rating')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="image" class="block text-sm font-medium text-gray-700">Imagen del producto</label>
        <div class="mt-1 flex items-center">
            @if($product && $product->image)
                <div class="relative">
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                        class="h-32 w-32 object-cover rounded-md">
                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity rounded-md">
                        <span class="text-white text-sm">Cambiar imagen</span>
                    </div>
                </div>
            @endif
            <input type="file" name="image" id="image" accept="image/*"
                class="ml-5 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
        </div>
        @error('image')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <div class="flex items-center">
            <input type="checkbox" name="is_featured" id="is_featured"
                value="1"
                {{ old('is_featured', $product?->is_featured) ? 'checked' : '' }}
                class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
            <label for="is_featured" class="ml-2 block text-sm text-gray-700">
                Marcar como producto destacado
            </label>
        </div>
        @error('is_featured')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>
