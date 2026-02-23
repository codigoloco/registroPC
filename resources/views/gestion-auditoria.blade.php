<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestión de Auditoria') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <x-consultar-auditoria-modal />        
    </div>
</x-app-layout>
