<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nuevo Ticket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <x-validation-errors class="mb-4" />

                    <form method="POST" action="{{ route('tickets.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-label for="titulo" value="{{ __('Título') }}" />
                            <x-input id="titulo" class="block mt-1 w-full" type="text" name="titulo" :value="old('titulo')" required autofocus />
                        </div>

                        <div class="mt-4">
                            <x-label for="descripcion" value="{{ __('Descripción') }}" />
                            <textarea id="descripcion" name="descripcion" rows="4" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>{{ old('descripcion') }}</textarea>
                        </div>

                        <div class="mt-4">
                            <x-label for="prioridad" value="{{ __('Prioridad') }}" />
                            <select id="prioridad" name="prioridad" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="">Seleccione una prioridad</option>
                                <option value="Alta" {{ old('prioridad') == 'Alta' ? 'selected' : '' }}>Alta</option>
                                <option value="Media" {{ old('prioridad') == 'Media' ? 'selected' : '' }}>Media</option>
                                <option value="Baja" {{ old('prioridad') == 'Baja' ? 'selected' : '' }}>Baja</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <x-label for="categoria" value="{{ __('Categoría') }}" />
                            <select id="categoria" name="categoria" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="">Seleccione una categoría</option>
                                <option value="Hardware" {{ old('categoria') == 'Hardware' ? 'selected' : '' }}>Hardware</option>
                                <option value="Software" {{ old('categoria') == 'Software' ? 'selected' : '' }}>Software</option>
                                <option value="Red" {{ old('categoria') == 'Red' ? 'selected' : '' }}>Red</option>
                                <option value="Otros" {{ old('categoria') == 'Otros' ? 'selected' : '' }}>Otros</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Crear Ticket') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>