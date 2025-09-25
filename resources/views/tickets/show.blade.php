<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalles del Ticket') }} #{{ $ticket->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    @if (session('success'))
                        <div class="mb-4 px-4 py-2 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-6">
                        <a href="{{ route('tickets.index') }}" class="text-indigo-600 hover:text-indigo-900">
                            ← Volver a la lista de tickets
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Información del Ticket</h3>
                            <dl class="grid grid-cols-1 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Título</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $ticket->titulo }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Descripción</dt>
                                    <dd class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ $ticket->descripcion }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Estado</dt>
                                    <dd class="mt-1">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($ticket->estado == 'Abierto') bg-green-100 text-green-800
                                            @elseif($ticket->estado == 'Asignado') bg-blue-100 text-blue-800
                                            @elseif($ticket->estado == 'En espera') bg-yellow-100 text-yellow-800
                                            @elseif($ticket->estado == 'Resuelto') bg-purple-100 text-purple-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ $ticket->estado }}
                                        </span>
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Prioridad</dt>
                                    <dd class="mt-1">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($ticket->prioridad == 'Alta') bg-red-100 text-red-800
                                            @elseif($ticket->prioridad == 'Media') bg-yellow-100 text-yellow-800
                                            @else bg-green-100 text-green-800
                                            @endif">
                                            {{ $ticket->prioridad }}
                                        </span>
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Categoría</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $ticket->categoria }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Asignación y Control</h3>
                            <dl class="grid grid-cols-1 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Cliente</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $ticket->cliente->name }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Técnico Asignado</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $ticket->tecnico ? $ticket->tecnico->name : 'Sin asignar' }}</dd>
                                </div>

                                @if(auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Técnico'))
                                <div class="mt-4">
                                    <form method="POST" action="{{ route('tickets.update-status', $ticket) }}" class="space-y-4">
                                        @csrf
                                        @method('PATCH')
                                        <div>
                                            <label for="estado" class="block text-sm font-medium text-gray-700">Actualizar Estado</label>
                                            <select id="estado" name="estado" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                                <option value="Abierto" {{ $ticket->estado == 'Abierto' ? 'selected' : '' }}>Abierto</option>
                                                <option value="Asignado" {{ $ticket->estado == 'Asignado' ? 'selected' : '' }}>Asignado</option>
                                                <option value="En espera" {{ $ticket->estado == 'En espera' ? 'selected' : '' }}>En espera</option>
                                                <option value="Resuelto" {{ $ticket->estado == 'Resuelto' ? 'selected' : '' }}>Resuelto</option>
                                                <option value="Cerrado" {{ $ticket->estado == 'Cerrado' ? 'selected' : '' }}>Cerrado</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            Actualizar Estado
                                        </button>
                                    </form>
                                </div>
                                @endif

                                @if(auth()->user()->hasRole('Administrador'))
                                <div class="mt-4">
                                    <form method="POST" action="{{ route('tickets.assign-technician', $ticket) }}" class="space-y-4">
                                        @csrf
                                        @method('PATCH')
                                        <div>
                                            <label for="tecnico_id" class="block text-sm font-medium text-gray-700">Asignar Técnico</label>
                                            <select id="tecnico_id" name="tecnico_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                                <option value="">Seleccionar técnico</option>
                                                @foreach($tecnicos as $tecnico)
                                                    <option value="{{ $tecnico->id }}" {{ $ticket->tecnico_id == $tecnico->id ? 'selected' : '' }}>
                                                        {{ $tecnico->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            Asignar Técnico
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>