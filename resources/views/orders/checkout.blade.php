<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 xl:gap-x-16">
                <!-- Formulario de checkout -->
                <div class="mt-10 lg:mt-0 order-2 lg:order-1">
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <div>
                                <h2 class="text-lg font-medium text-gray-900">Información de contacto</h2>

                                <div class="mt-4">
                                    <p class="text-sm text-gray-600">
                                        Realizando compra como <span class="font-medium text-gray-900">{{ Auth::user()->email }}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="mt-6">
                                <h3 class="text-lg font-medium text-gray-900">Dirección de envío</h3>

                                <div class="mt-4">
                                    <label for="shipping_address" class="block text-sm font-medium text-gray-700">Dirección completa</label>
                                    <textarea name="shipping_address" id="shipping_address" rows="3" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        placeholder="Ingresa tu dirección completa de envío">{{ old('shipping_address') }}</textarea>
                                    @error('shipping_address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mt-4">
                                    <div class="flex items-center">
                                        <input id="same_address" name="same_address" type="checkbox" checked
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="same_address" class="ml-2 text-sm text-gray-700">
                                            Usar la misma dirección para facturación
                                        </label>
                                    </div>
                                </div>

                                <div id="billing_address_container" class="mt-4 hidden">
                                    <label for="billing_address" class="block text-sm font-medium text-gray-700">Dirección de facturación</label>
                                    <textarea name="billing_address" id="billing_address" rows="3"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        placeholder="Ingresa tu dirección de facturación">{{ old('billing_address') }}</textarea>
                                    @error('billing_address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-6">
                                <h3 class="text-lg font-medium text-gray-900">Método de pago</h3>

                                <div class="mt-4 space-y-4">
                                    <div class="flex items-center">
                                        <input id="payment_method_credit_card" name="payment_method" type="radio" value="credit_card" required
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <label for="payment_method_credit_card" class="ml-3 text-sm text-gray-700">
                                            Tarjeta de crédito/débito
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="payment_method_paypal" name="payment_method" type="radio" value="paypal"
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <label for="payment_method_paypal" class="ml-3 text-sm text-gray-700">
                                            PayPal
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="payment_method_bank_transfer" name="payment_method" type="radio" value="bank_transfer"
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <label for="payment_method_bank_transfer" class="ml-3 text-sm text-gray-700">
                                            Transferencia bancaria
                                        </label>
                                    </div>
                                    @error('payment_method')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mt-4">
                                    <label for="notes" class="block text-sm font-medium text-gray-700">Notas adicionales (opcional)</label>
                                    <textarea name="notes" id="notes" rows="2"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        placeholder="Instrucciones especiales para la entrega...">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="w-full bg-blue-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Confirmar pedido
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Resumen del pedido -->
                <div class="bg-white rounded-lg shadow-sm p-6 order-1 lg:order-2">
                    <h2 class="text-lg font-medium text-gray-900">Resumen del pedido</h2>

                    <div class="mt-6">
                        <div class="flow-root">
                            <ul class="-my-6 divide-y divide-gray-200">
                                @foreach($cart->items as $item)
                                    <li class="py-6 flex">
                                        <div class="flex-shrink-0 w-24 h-24 border border-gray-200 rounded-md overflow-hidden">
                                            @if($item->product->image)
                                                <img src="{{ Storage::url($item->product->image) }}"
                                                    alt="{{ $item->product->name }}"
                                                    class="w-full h-full object-center object-cover">
                                            @else
                                                <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                                    <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="ml-4 flex-1 flex flex-col">
                                            <div>
                                                <div class="flex justify-between text-base font-medium text-gray-900">
                                                    <h3>{{ $item->product->name }}</h3>
                                                    <p class="ml-4">${{ number_format($item->subtotal, 2) }}</p>
                                                </div>
                                                <p class="mt-1 text-sm text-gray-500">{{ $item->product->platform }}</p>
                                            </div>
                                            <div class="flex-1 flex items-end justify-between text-sm">
                                                <p class="text-gray-500">Cantidad: {{ $item->quantity }}</p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 mt-6 pt-6">
                        <div class="flex justify-between text-base font-medium text-gray-900">
                            <p>Subtotal</p>
                            <p>${{ number_format($cart->total, 2) }}</p>
                        </div>
                        <p class="mt-0.5 text-sm text-gray-500">Impuestos y envío calculados al finalizar la compra.</p>
                    </div>

                    <div class="border-t border-gray-200 mt-6 pt-6">
                        <div class="flex justify-between text-base font-medium text-gray-900">
                            <p>Total</p>
                            <p>${{ number_format($cart->total, 2) }}</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('cart.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                            Volver al carrito
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('same_address').addEventListener('change', function() {
            const billingAddressContainer = document.getElementById('billing_address_container');
            billingAddressContainer.classList.toggle('hidden');

            const billingAddressInput = document.getElementById('billing_address');
            if (this.checked) {
                billingAddressInput.removeAttribute('required');
            } else {
                billingAddressInput.setAttribute('required', 'required');
            }
        });
    </script>
    @endpush
</x-app-layout>
