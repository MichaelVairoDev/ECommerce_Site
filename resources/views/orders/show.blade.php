<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Pedido #{{ $order->order_number }}</h2>
                        <a href="{{ route('orders.index') }}" class="text-blue-600 hover:underline">
                            Volver a mis pedidos
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Información del pedido -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Información del pedido</h3>
                            <dl class="grid grid-cols-1 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Estado del pedido</dt>
                                    <dd class="mt-1">
                                        @switch($order->status)
                                            @case('pending')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Pendiente
                                                </span>
                                                @break
                                            @case('processing')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    En proceso
                                                </span>
                                                @break
                                            @case('completed')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Completado
                                                </span>
                                                @break
                                            @case('cancelled')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Cancelado
                                                </span>
                                                @break
                                            @default
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                        @endswitch
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Fecha del pedido</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $order->created_at->format('d/m/Y H:i') }}</dd>
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
                        </div>

                        <!-- Información de envío y facturación -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Información de envío y facturación</h3>
                            <dl class="grid grid-cols-1 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Dirección de envío</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $order->shipping_address }}</dd>
                                </div>

                                @if($order->billing_address && $order->billing_address !== $order->shipping_address)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Dirección de facturación</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $order->billing_address }}</dd>
                                    </div>
                                @endif

                                @if($order->notes)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Notas adicionales</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $order->notes }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    </div>

                    <!-- Productos del pedido -->
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Productos</h3>
                        <div class="flex flex-col">
                            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                    <div class="overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Producto
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Precio unitario
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Cantidad
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Subtotal
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($order->items as $item)
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="flex items-center">
                                                                <div class="flex-shrink-0 h-10 w-10">
                                                                    @if($item->product->image)
                                                                        <img class="h-10 w-10 rounded-full object-cover"
                                                                            src="{{ Storage::url($item->product->image) }}"
                                                                            alt="{{ $item->product->name }}">
                                                                    @else
                                                                        <div class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center">
                                                                            <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                            </svg>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="ml-4">
                                                                    <div class="text-sm font-medium text-gray-900">
                                                                        {{ $item->product->name }}
                                                                    </div>
                                                                    <div class="text-sm text-gray-500">
                                                                        {{ $item->product->platform }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="text-sm text-gray-900">
                                                                ${{ number_format($item->price, 2) }}
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="text-sm text-gray-900">{{ $item->quantity }}</div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="text-sm text-gray-900">
                                                                ${{ number_format($item->subtotal, 2) }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Resumen del pedido -->
                    <div class="mt-8">
                        <div class="bg-gray-50 rounded-lg py-6 px-4 sm:px-6">
                            <div class="flex justify-between text-base font-medium text-gray-900">
                                <p>Total</p>
                                <p>${{ number_format($order->total_amount, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
