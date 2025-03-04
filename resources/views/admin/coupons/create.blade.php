<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Crear Nuevo Cupón</h2>

                    <form action="{{ route('admin.coupons.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="code" class="block text-sm font-medium text-gray-700">Código del Cupón</label>
                                <input type="text" name="code" id="code" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>

                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700">Tipo de Descuento</label>
                                <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="fixed">Monto Fijo</option>
                                    <option value="percentage">Porcentaje</option>
                                </select>
                            </div>

                            <div>
                                <label for="value" class="block text-sm font-medium text-gray-700">Valor del Descuento</label>
                                <input type="number" name="value" id="value" step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>

                            <div>
                                <label for="min_purchase" class="block text-sm font-medium text-gray-700">Compra Mínima (opcional)</label>
                                <input type="number" name="min_purchase" id="min_purchase" step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="max_uses" class="block text-sm font-medium text-gray-700">Usos Máximos (opcional)</label>
                                <input type="number" name="max_uses" id="max_uses" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="starts_at" class="block text-sm font-medium text-gray-700">Fecha de Inicio (opcional)</label>
                                <input type="datetime-local" name="starts_at" id="starts_at" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="expires_at" class="block text-sm font-medium text-gray-700">Fecha de Expiración (opcional)</label>
                                <input type="datetime-local" name="expires_at" id="expires_at" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" checked>
                                <label for="is_active" class="ml-2 block text-sm text-gray-900">Cupón Activo</label>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end">
                            <a href="{{ route('admin.coupons.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Crear Cupón
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>