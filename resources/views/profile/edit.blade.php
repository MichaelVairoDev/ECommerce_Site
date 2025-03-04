@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Menú de navegación del perfil -->
                <div class="col-span-1">
                    <div class="bg-white shadow sm:rounded-lg">
                        <div class="p-4">
                            <h3 class="text-lg font-medium text-gray-900">Navegación</h3>
                            <nav class="mt-4 space-y-2">
                                <a href="#profile-info" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-md">
                                    Información del perfil
                                </a>
                                <a href="#orders" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-md">
                                    Mis pedidos
                                </a>
                                <a href="#security" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-md">
                                    Seguridad
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- Contenido principal -->
                <div class="col-span-1 md:col-span-2 space-y-6">
                    <!-- Información del perfil -->
                    <div id="profile-info" class="bg-white shadow sm:rounded-lg">
                        <div class="p-4 sm:p-8">
                            <div class="max-w-xl">
                                @include('profile.partials.update-profile-information-form')
                            </div>
                        </div>
                    </div>

                    <!-- Historial de pedidos -->
                    <div id="orders" class="bg-white shadow sm:rounded-lg">
                        <div class="p-4 sm:p-8">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">
                                Historial de pedidos
                            </h2>

                            @if($orders->isEmpty())
                                <div class="text-center py-6">
                                    <p class="text-gray-500">No tienes pedidos realizados aún.</p>
                                    <a href="{{ route('products.index') }}" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                                        Ver catálogo
                                    </a>
                                </div>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Pedido #
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Fecha
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Total
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Estado
                                                </th>
                                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Acciones
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($orders as $order)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        {{ $order->id }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $order->created_at->format('d/m/Y H:i') }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        ${{ number_format($order->total, 2) }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                            @if($order->status === 'completed') bg-green-100 text-green-800
                                                            @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                                                            @else bg-gray-100 text-gray-800 @endif">
                                                            {{ ucfirst($order->status) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <a href="{{ route('orders.show', $order) }}" class="text-blue-600 hover:text-blue-900">
                                                            Ver detalles
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Seguridad -->
                    <div id="security" class="space-y-6">
                        <!-- Actualizar contraseña -->
                        <div class="bg-white shadow sm:rounded-lg">
                            <div class="p-4 sm:p-8">
                                <div class="max-w-xl">
                                    @include('profile.partials.update-password-form')
                                </div>
                            </div>
                        </div>

                        <!-- Eliminar cuenta -->
                        <div class="bg-white shadow sm:rounded-lg">
                            <div class="p-4 sm:p-8">
                                <div class="max-w-xl">
                                    @include('profile.partials.delete-user-form')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
