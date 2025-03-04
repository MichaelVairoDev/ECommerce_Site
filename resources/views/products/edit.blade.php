<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Editar Producto</h2>
                        <div class="flex space-x-4">
                            <a href="{{ route('products.show', $product) }}" class="text-blue-600 hover:underline">
                                Ver producto
                            </a>
                            <a href="{{ route('products.index') }}" class="text-blue-600 hover:underline">
                                Volver al catálogo
                            </a>
                        </div>
                    </div>

                    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <x-products.form :product="$product" :categories="$categories" />

                        <div class="mt-6 flex justify-end space-x-4">
                            <button type="button"
                                onclick="if(confirm('¿Estás seguro de que deseas eliminar este producto?')) document.getElementById('delete-form').submit();"
                                class="inline-flex items-center px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Eliminar producto
                            </button>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Guardar cambios
                            </button>
                        </div>
                    </form>

                    <form id="delete-form" action="{{ route('products.destroy', $product) }}" method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
