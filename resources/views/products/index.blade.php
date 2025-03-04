@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filtros y búsqueda -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <form action="{{ route('products.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200"
                            placeholder="Nombre o descripción...">
                    </div>
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                        <select name="category" id="category" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200">
                            <option value="">Todas las categorías</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="platform" class="block text-sm font-medium text-gray-700 mb-1">Plataforma</label>
                        <select name="platform" id="platform" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200">
                            <option value="">Todas las plataformas</option>
                            @foreach($platforms as $platform)
                                <option value="{{ $platform->platform }}" {{ request('platform') == $platform->platform ? 'selected' : '' }}>
                                    {{ $platform->platform }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Ordenar por</label>
                        <select name="sort" id="sort" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Más recientes</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Precio: menor a mayor</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Precio: mayor a menor</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nombre</option>
                        </select>
                    </div>
                    <div class="md:col-span-4 flex justify-end space-x-4">
                        @if(request()->anyFilled(['search', 'category', 'platform', 'sort']))
                            <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                Limpiar filtros
                            </a>
                        @endif
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                            Aplicar filtros
                        </button>
                    </div>
                </form>
            </div>
            <!-- Lista de productos -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900">
                        Catálogo de Videojuegos
                    </h2>
                    @can('create', App\Models\Product::class)
                        <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                            <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Nuevo Producto
                        </a>
                    @endcan
                </div>
                <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                    @forelse($products as $product)
                        <div class="group relative">
                            <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 group-hover:opacity-75">
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                                        class="h-full w-full object-cover object-center">
                                @else
                                    <img src="{{ asset('ph_products.jpg') }}" alt="{{ $product->name }}"
                                        class="h-full w-full object-cover object-center">
                                @endif
                            </div>
                            <div class="mt-4 flex justify-between">
                                <div>
                                    <h3 class="text-sm text-gray-700">
                                        <a href="{{ route('products.show', $product->slug) }}">
                                            <span aria-hidden="true" class="absolute inset-0"></span>
                                            {{ $product->name }}
                                        </a>
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">{{ $product->platform }}</p>
                                </div>
                                <p class="text-sm font-medium text-gray-900">${{ number_format($product->price, 2) }}</p>
                            </div>
                            @if($product->stock < 1)
                                <span class="absolute top-0 right-0 m-2 px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded">
                                    Agotado
                                </span>
                            @elseif($product->is_featured)
                                <span class="absolute top-0 right-0 m-2 px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded">
                                    Destacado
                                </span>
                            @endif
                        </div>
                    @empty
                        <div class="col-span-4 text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No se encontraron productos</h3>
                            <p class="mt-1 text-sm text-gray-500">Prueba ajustando los filtros de búsqueda.</p>
                        </div>
                    @endforelse
                </div>
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
