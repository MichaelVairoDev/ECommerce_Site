<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="text-center">
                        <svg class="mx-auto h-12 w-12 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h2 class="mt-4 text-2xl font-bold text-gray-900">¡Gracias por tu compra!</h2>
                        <p class="mt-2 text-sm text-gray-600">
                            Tu número de pedido es: <span class="font-medium text-gray-900">{{ $order->order_number }}</span>
                        </p>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900">Detalles del pedido</h3>

                        <dl class="mt-4 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Fecha del pedido</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $order->created_at->format('d/m/Y H:i') }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Estado del pedido</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($order->status) }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Método de pago</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($order->payment_method) }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Estado del pago</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($order->payment_status) }}</dd>
                            </div>
                        </dl>

                        <div class="mt-6">
                            <h4 class="text-sm font-medium text-gray-900">Dirección de envío</h4>
                            <p class="mt-1 text-sm text-gray-600">{{ $order->shipping_address }}</p>
                        </div>

                        @if($order->billing_address && $order->billing_address !== $order->shipping_address)
                            <div class="mt-4">
                                <h4 class="text-sm font-medium text-gray-900">Dirección de facturación</h4>
                                <p class="mt-1 text-sm text-gray-600">{{ $order->billing_address }}</p>
                            </div>
                        @endif

                        @if($order->notes)
                            <div class="mt-4">
                                <h4 class="text-sm font-medium text-gray-900">Notas adicionales</h4>
                                <p class="mt-1 text-sm text-gray-600">{{ $order->notes }}</p>
                            </div>
                        @endif

                        <div class="mt-8">
                            <h4 class="text-lg font-medium text-gray-900">Productos</h4>
                            <div class="mt-4">
                                <div class="flow-root">
                                    <ul class="-my-6 divide-y divide-gray-200">
                                        @foreach($order->items as $item)
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
                        </div>

                        <div class="mt-8">
                            <div class="bg-gray-50 rounded-lg py-6 px-4 sm:px-6">
                                <div class="flex justify-between text-base font-medium text-gray-900">
                                    <p>Total</p>
                                    <p>${{ number_format($order->total_amount, 2) }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-center space-x-4">
                            <a href="{{ route('orders.index') }}"
                                class="flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                                Ver mis pedidos
                            </a>
                            <a href="{{ route('products.index') }}"
                                class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                Seguir comprando
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
