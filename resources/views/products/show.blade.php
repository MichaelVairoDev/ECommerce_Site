@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-x-8 lg:items-start">
                <!-- Imagen del producto -->
                <div class="flex flex-col-reverse">
                    <div class="w-full aspect-w-1 aspect-h-1 rounded-lg overflow-hidden bg-gray-100">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                                class="w-full h-full object-center object-cover">
                        @else
                            <img src="{{ asset('ph_products.jpg') }}" alt="{{ $product->name }}"
                                class="w-full h-full object-center object-cover">
                        @endif
                    </div>
                </div>

                <!-- Información del producto -->
                <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0">
                    <div class="flex justify-between items-center">
                        <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">{{ $product->name }}</h1>
                        @can('update', $product)
                            <div class="flex space-x-2">
                                <a href="{{ route('products.edit', $product) }}"
                                    class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Editar
                                </a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST"
                                    onsubmit="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center px-3 py-2 border border-red-300 shadow-sm text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        @endcan
                    </div>

                    <div class="mt-3">
                        <h2 class="sr-only">Información del producto</h2>
                        <p class="text-3xl text-gray-900">${{ number_format($product->price, 2) }}</p>
                    </div>

                    <!-- Detalles -->
                    <div class="mt-6">
                        <h3 class="sr-only">Descripción</h3>
                        <div class="text-base text-gray-700 space-y-6">
                            {{ $product->description }}
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Plataforma</h4>
                            <p class="mt-1 text-sm text-gray-500">{{ $product->platform }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Categoría</h4>
                            <p class="mt-1 text-sm text-gray-500">{{ $product->category->name }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Desarrolladora</h4>
                            <p class="mt-1 text-sm text-gray-500">{{ $product->developer ?? 'No especificado' }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Distribuidora</h4>
                            <p class="mt-1 text-sm text-gray-500">{{ $product->publisher ?? 'No especificado' }}</p>
                        </div>
                        @if($product->release_date)
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Fecha de lanzamiento</h4>
                                <p class="mt-1 text-sm text-gray-500">{{ $product->release_date->format('d/m/Y') }}</p>
                            </div>
                        @endif
                        @if($product->rating)
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Clasificación ESRB</h4>
                                <p class="mt-1 text-sm text-gray-500">{{ $product->rating }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="mt-8">
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <div class="mt-4">
                                    <label for="quantity" class="block text-sm font-medium text-gray-700">
                                        Cantidad ({{ $product->stock }} disponibles)
                                    </label>
                                    <select id="quantity" name="quantity"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        @for($i = 1; $i <= min($product->stock, 10); $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <button type="submit"
                                    class="mt-8 w-full bg-blue-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Agregar al carrito
                                </button>
                            </form>
                        @else
                            <button type="button" disabled
                                class="mt-8 w-full bg-gray-400 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white cursor-not-allowed">
                                Producto agotado
                            </button>
                        @endif
                    </div>

                    <!-- Mensajes de estado -->
                    @if(session('success'))
                        <div class="mt-4 bg-green-50 border border-green-200 rounded-md p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800">
                                        {{ session('success') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mt-4 bg-red-50 border border-red-200 rounded-md p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-red-800">
                                        {{ session('error') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sección de reseñas -->
            <div class="mt-16 border-t border-gray-200 pt-10">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">Reseñas y valoraciones</h2>

                <div class="mt-6 lg:grid lg:grid-cols-12 lg:gap-x-8">
                    <!-- Resumen de valoraciones -->
                    <div class="lg:col-span-4">
                        <div class="flex items-center">
                            <p class="text-3xl font-bold text-gray-900">{{ number_format($product->getAverageRatingAttribute(), 1) }}</p>
                            <div class="ml-4">
                                <!-- Estrellas basadas en la puntuación media -->
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= round($product->getAverageRatingAttribute()))
                                            <svg class="text-yellow-400 h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @else
                                            <svg class="text-gray-300 h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Basado en {{ $product->getReviewsCountAttribute() }} reseñas</p>
                            </div>
                        </div>
                    </div>

                    <!-- Lista de reseñas -->
                    <div class="mt-8 lg:mt-0 lg:col-span-8">
                        @if($product->reviews()->where('approved', true)->count() > 0)
                            <div class="flow-root">
                                <div class="-my-6 divide-y divide-gray-200">
                                    @foreach($product->reviews()->where('approved', true)->latest()->get() as $review)
                                        <div class="py-6">
                                            <div class="flex items-center">
                                                <div>
                                                    <h3 class="text-sm font-medium text-gray-900">{{ $review->user->name }}</h3>
                                                    <div class="mt-1 flex items-center">
                                                        <!-- Estrellas de la reseña -->
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= $review->rating)
                                                                <svg class="text-yellow-400 h-4 w-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                            @else
                                                                <svg class="text-gray-300 h-4 w-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    <p class="text-xs text-gray-500">{{ $review->created_at->format('d/m/Y') }}</p>
                                                </div>

                                                @if(Auth::check() && (Auth::user()->id == $review->user_id || Auth::user()->is_admin))
                                                    <div class="ml-4 flex space-x-2">
                                                        @if(Auth::user()->id == $review->user_id)
                                                            <!-- Botón para editar - Mostrar modal -->
                                                            <button type="button"
                                                                onclick="openEditReviewModal('{{ $review->id }}', '{{ $review->rating }}', '{{ addslashes($review->comment) }}')"
                                                                class="text-xs text-blue-600 hover:text-blue-900">
                                                                Editar
                                                            </button>
                                                        @endif

                                                        <form action="{{ route('reviews.destroy', $review) }}" method="POST"
                                                            onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta reseña?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-xs text-red-600 hover:text-red-900">
                                                                Eliminar
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif

                                                @if(Auth::check() && Auth::user()->is_admin && !$review->approved)
                                                    <div class="ml-4 flex space-x-2">
                                                        <form action="{{ route('reviews.approve', $review) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="text-xs text-green-600 hover:text-green-900">
                                                                Aprobar
                                                            </button>
                                                        </form>

                                                        <form action="{{ route('reviews.reject', $review) }}" method="POST"
                                                            onsubmit="return confirm('¿Estás seguro de que deseas rechazar esta reseña?');">
                                                            @csrf
                                                            <button type="submit" class="text-xs text-red-600 hover:text-red-900">
                                                                Rechazar
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                            @if($review->comment)
                                                <div class="mt-4 space-y-2 text-sm text-gray-600">
                                                    <p>{{ $review->comment }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="text-center py-6">
                                <p class="text-gray-500">Este producto aún no tiene reseñas.</p>
                            </div>
                        @endif

                        <!-- Formulario para agregar reseña -->
                        @auth
                            @php
                                $userReview = $product->reviews()->where('user_id', Auth::id())->first();
                            @endphp

                            @if(!$userReview)
                                <div class="mt-8 border-t border-gray-200 pt-8">
                                    <h3 class="text-lg font-medium text-gray-900">Deja tu opinión</h3>
                                    <form action="{{ route('reviews.store', $product) }}" method="POST" class="mt-4">
                                        @csrf
                                        <div>
                                            <label for="rating" class="block text-sm font-medium text-gray-700">Puntuación</label>
                                            <div class="mt-1 flex items-center">
                                                <div class="star-rating">
                                                    <input type="radio" id="rating-5" name="rating" value="5" required>
                                                    <label for="rating-5"><span class="sr-only">5 estrellas</span></label>
                                                    <input type="radio" id="rating-4" name="rating" value="4" required>
                                                    <label for="rating-4"><span class="sr-only">4 estrellas</span></label>
                                                    <input type="radio" id="rating-3" name="rating" value="3" required>
                                                    <label for="rating-3"><span class="sr-only">3 estrellas</span></label>
                                                    <input type="radio" id="rating-2" name="rating" value="2" required>
                                                    <label for="rating-2"><span class="sr-only">2 estrellas</span></label>
                                                    <input type="radio" id="rating-1" name="rating" value="1" required>
                                                    <label for="rating-1"><span class="sr-only">1 estrella</span></label>
                                                </div>
                                            </div>
                                            @error('rating')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="mt-4">
                                            <label for="comment" class="block text-sm font-medium text-gray-700">Comentario (opcional)</label>
                                            <textarea id="comment" name="comment" rows="3"
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                                placeholder="Comparte tu experiencia con este producto..."></textarea>
                                        </div>
                                        <div class="mt-4">
                                            <button type="submit"
                                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                Enviar reseña
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @else
                                <div class="mt-8 border-t border-gray-200 pt-8">
                                    <h3 class="text-lg font-medium text-gray-900">Tu reseña</h3>
                                    <div class="mt-4 bg-blue-50 p-4 rounded-md">
                                        <p class="text-sm text-blue-700">
                                            Ya has dejado una reseña para este producto.
                                            @if(!$userReview->approved)
                                                 Tu reseña está pendiente de aprobación.
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="mt-8 border-t border-gray-200 pt-8">
                                <div class="bg-gray-50 p-4 rounded-md">
                                    <p class="text-sm text-gray-700">
                                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-500">Inicia sesión</a>
                                        para dejar tu opinión sobre este producto.
                                    </p>
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Modal para editar reseña -->
            <div id="editReviewModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
                <div class="bg-white rounded-lg p-6 max-w-md w-full">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Editar tu reseña</h3>
                        <button type="button" onclick="closeEditReviewModal()" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <form id="editReviewForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="edit-rating" class="block text-sm font-medium text-gray-700">Puntuación</label>
                            <div class="mt-1">
                                <select id="edit-rating" name="rating" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="1">1 estrella</option>
                                    <option value="2">2 estrellas</option>
                                    <option value="3">3 estrellas</option>
                                    <option value="4">4 estrellas</option>
                                    <option value="5">5 estrellas</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-4">
                            <label for="edit-comment" class="block text-sm font-medium text-gray-700">Comentario (opcional)</label>
                            <textarea id="edit-comment" name="comment" rows="3"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                        </div>
                        <div class="mt-5 flex justify-end">
                            <button type="button" onclick="closeEditReviewModal()" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 mr-3">
                                Cancelar
                            </button>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                Guardar cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Productos relacionados -->
            @if($relatedProducts->isNotEmpty())
                <div class="mt-16">
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900">Productos relacionados</h2>
                    <div class="mt-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach($relatedProducts as $relatedProduct)
                            <div class="group relative">
                                <div class="w-full aspect-w-1 aspect-h-1 rounded-lg overflow-hidden bg-gray-200">
                                    @if($relatedProduct->image)
                                        <img src="{{ Storage::url($relatedProduct->image) }}"
                                            alt="{{ $relatedProduct->name }}"
                                            class="w-full h-full object-center object-cover group-hover:opacity-75">
                                    @else
                                        <img src="{{ asset('ph_products.jpg') }}"
                                            alt="{{ $relatedProduct->name }}"
                                            class="w-full h-full object-center object-cover group-hover:opacity-75">
                                    @endif
                                </div>
                                <div class="mt-4 flex justify-between">
                                    <div>
                                        <h3 class="text-sm text-gray-700">
                                            <a href="{{ route('products.show', $relatedProduct->slug) }}">
                                                <span aria-hidden="true" class="absolute inset-0"></span>
                                                {{ $relatedProduct->name }}
                                            </a>
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-500">{{ $relatedProduct->platform }}</p>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900">
                                        ${{ number_format($relatedProduct->price, 2) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('styles')
    <style>
        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
        }
        .star-rating input {
            display: none;
        }
        .star-rating label {
            cursor: pointer;
            width: 24px;
            height: 24px;
        }
        .star-rating label:before {
            content: '★';
            color: #ddd;
            font-size: 24px;
        }
        .star-rating input:checked ~ label:before,
        .star-rating label:hover:before,
        .star-rating label:hover ~ label:before {
            color: #fbbf24;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        function openEditReviewModal(reviewId, rating, comment) {
            const modal = document.getElementById('editReviewModal');
            const form = document.getElementById('editReviewForm');
            const ratingSelect = document.getElementById('edit-rating');
            const commentTextarea = document.getElementById('edit-comment');
            // Set form action URL
            form.action = `/reviews/${reviewId}`;
            // Set existing values
            ratingSelect.value = rating;
            commentTextarea.value = comment;
            // Show modal
            modal.classList.remove('hidden');
        }
        function closeEditReviewModal() {
            const modal = document.getElementById('editReviewModal');
            modal.classList.add('hidden');
        }
    </script>
    @endpush
@endsection
