@extends('layouts.app')

@section('content')
    <div class="relative bg-blue-900 overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 sm:pb-16 md:pb-20 lg:w-full lg:pb-28 xl:pb-32">
                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                            <span class="block">Los mejores videojuegos</span>
                            <span class="block text-blue-400">al mejor precio</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-300 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Explora nuestra colección de videojuegos. Tenemos los últimos lanzamientos y los clásicos de siempre.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a href="{{ route('products.index') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 md:py-4 md:text-lg md:px-10">
                                    Ver catálogo
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Productos Destacados -->
            <div class="mb-12">
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 mb-6">
                    Productos Destacados
                </h2>
                <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                    @foreach ($featuredProducts as $product)
                        <div class="group relative">
                            <div class="w-full h-80 bg-gray-200 rounded-lg overflow-hidden group-hover:opacity-75">
                                @if ($product->image)
                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-center object-cover">
                                @else
                                    <img src="{{ asset('ph_products.jpg') }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-center object-cover">
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
                                <p class="text-sm font-medium text-blue-600">${{ number_format($product->price, 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Últimos Lanzamientos -->
            <div>
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 mb-6">
                    Últimos Lanzamientos
                </h2>
                <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                    @foreach ($latestProducts as $product)
                        <div class="group relative">
                            <div class="w-full h-80 bg-gray-200 rounded-lg overflow-hidden group-hover:opacity-75">
                                @if ($product->image)
                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-center object-cover">
                                @else
                                    <img src="{{ asset('ph_products.jpg') }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-center object-cover">
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
                                <p class="text-sm font-medium text-blue-600">${{ number_format($product->price, 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 text-center">
                    <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Ver todos los productos
                    </a>
                </div>
            </div>

            <!-- Categorías -->
            <div class="mt-16">
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 mb-6">
                    Explora por Categoría
                </h2>
                <div class="grid grid-cols-1 gap-y-4 sm:grid-cols-2 sm:gap-x-6 sm:gap-y-10 lg:grid-cols-4 lg:gap-x-8">
                    @foreach ($categories as $category)
                        <a href="{{ route('products.index', ['category' => $category->id]) }}"
                            class="group relative bg-white border border-gray-200 rounded-lg flex flex-col overflow-hidden hover:shadow-lg transition-shadow">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    {{ $category->name }}
                                </h3>
                                <p class="mt-2 text-sm text-gray-500">
                                    {{ $category->description }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
