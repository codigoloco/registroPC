<div x-show="showModalModificarClientes" style="display: none;"
    class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0">

    <!-- Fondo Oscuro (Backdrop) -->
    <div x-show="showModalModificarClientes" class="fixed inset-0 transform transition-all"
        x-on:click="showModalModificarClientes = false" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
    </div>

    <!-- Panel del Modal -->
    <div x-show="showModalModificarClientes"
        class="mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-4xl sm:mx-auto"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-data="{
            searchCedula: '',
            cliente: {
                id: '',
                nombre: '',
                apellido: '',
                direccion: '',
                tipo_cliente: '',
                contactos: []
            },
            telefonos: [''],
            emails: [''],
            loading: false,
            error: '',
            buscarCliente() {
                if (!this.searchCedula) return;
                this.loading = true;
                this.error = '';
                fetch(`/clientes/search/${this.searchCedula}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            this.error = data.error;
                            this.reset();
                        } else {
                            this.cliente = data;
                            this.telefonos = data.contactos.map(c => c.telefono_cliente);
                            this.emails = data.contactos.map(c => c.correo_cliente);
                            if (this.telefonos.length === 0) this.telefonos = [''];
                            if (this.emails.length === 0) this.emails = [''];
                        }
                    })
                    .catch(err => {
                        this.error = 'Error al buscar';
                        console.error(err);
                    })
                    .finally(() => this.loading = false);
            },
            reset() {
                this.cliente = { id: '', nombre: '', apellido: '', direccion: '', tipo_cliente: '', contactos: [] };
                this.telefonos = [''];
                this.emails = [''];
            }
        }">

        <!-- Encabezado -->
        <div class="bg-blue-600 text-white px-6 py-4 flex items-center justify-between shadow-sm">
            <span class="text-lg font-semibold">{{ __('Modificar Cliente') }}</span>
            <button @click="showModalModificarClientes = false"
                class="text-white hover:text-gray-200 focus:outline-none">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form action="{{ route('clientes.update') }}" method="POST">
            @csrf
            <input type="hidden" name="cedula" :value="cliente.id">
            <div class="p-8 space-y-8">

                <!-- Sección: Consultar Cliente -->
                <div>
                    <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-4 border-b dark:border-gray-700 pb-2">
                        {{ __('Consultar Cliente') }}
                    </h3>
                    <div class="flex flex-col md:flex-row gap-4 items-end">
                        <div class="w-full md:w-1/2">
                            <x-label value="Cedula/RIF" class="mb-1" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <x-input type="text" placeholder="Cedula/RIF" class="w-full pl-10"
                                    x-model="searchCedula" x-imask="'number'" @keyup.enter="buscarCliente()" />
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <x-button type="button" @click="buscarCliente()"
                                class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500">
                                <span x-show="!loading">{{ __('Consultar') }}</span>
                                <span x-show="loading">{{ __('Buscando...') }}</span>
                            </x-button>
                        </div>
                    </div>
                    <template x-if="error">
                        <p class="text-red-500 text-xs mt-2" x-text="error"></p>
                    </template>
                </div>

                <!-- Sección: Detalles del Cliente -->
                <div>
                    <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-4 border-b dark:border-gray-700 pb-2">
                        {{ __('Detalles del Cliente') }}
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Columna Izquierda -->
                        <div class="space-y-4">
                            <div>
                                <x-label value="Cedula/RIF" class="mb-1" />
                                <x-input type="text" placeholder="Cedula/RIF"
                                    class="w-full bg-gray-100 cursor-not-allowed" x-model="cliente.id" readonly />
                            </div>
                            <div>
                                <x-label value="Nombre" class="mb-1" />
                                <x-input type="text" name="nombre" placeholder="Nombre" class="w-full" maxlength="100"
                                    x-model="cliente.nombre" x-imask="'text'" required />
                            </div>
                            <div>
                                <x-label value="Apellido" class="mb-1" />
                                <x-input type="text" name="apellido" placeholder="Apellido" class="w-full"
                                    maxlength="100" x-model="cliente.apellido" x-imask="'text'" required />
                            </div>
                            <div>
                                <x-label value="Dirección" class="mb-1" />
                                <textarea name="direccion" placeholder="Dirección" x-model="cliente.direccion"
                                    class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm h-24"
                                    required></textarea>
                            </div>
                            <div>
                                <x-label value="Tipo de Cliente" class="mb-1" />
                                <select name="tipo_cliente" x-model="cliente.tipo_cliente"
                                    class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm h-10"
                                    required>
                                    <option value="natural">Natural</option>
                                    <option value="juridico">Jurídico</option>
                                    <option value="Gubernamental">Gubernamental</option>
                                </select>
                            </div>
                        </div>
                        <!-- Columna Derecha -->
                        <div class="space-y-4">
                            <div
                                class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800/50">
                                <div class="flex items-center justify-between mb-3">
                                    <x-label value="Números de Contacto" class="font-bold" />
                                    <button type="button" @click="telefonos.push('')"
                                        class="text-xs bg-indigo-600 hover:bg-indigo-700 text-white px-2 py-1 rounded flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                        {{ __('Añadir') }}
                                    </button>
                                </div>
                                <div class="space-y-2">
                                    <template x-for="(tel, index) in telefonos" :key="index">
                                        <div class="flex items-center gap-2">
                                            <x-input type="text" name="telefonos[]" x-model="telefonos[index]"
                                                placeholder="Número de teléfono" class="w-full" x-imask="'number'" required />
                                            <button type="button" x-show="telefonos.length > 1"
                                                @click="telefonos.splice(index, 1)"
                                                class="text-red-500 hover:text-red-700 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            <div
                                class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800/50">
                                <div class="flex items-center justify-between mb-3">
                                    <x-label value="Correos Electrónicos" class="font-bold" />
                                    <button type="button" @click="emails.push('')"
                                        class="text-xs bg-indigo-600 hover:bg-indigo-700 text-white px-2 py-1 rounded flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                        {{ __('Añadir') }}
                                    </button>
                                </div>
                                <div class="space-y-2">
                                    <template x-for="(email, index) in emails" :key="index">
                                        <div class="flex items-center gap-2">
                                            <x-input type="email" name="emails[]" x-model="emails[index]"
                                                placeholder="correo@ejemplo.com" class="w-full" required />
                                            <button type="button" x-show="emails.length > 1"
                                                @click="emails.splice(index, 1)"
                                                class="text-red-500 hover:text-red-700 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Footer -->
            <div
                class="bg-gray-50 dark:bg-gray-700 px-6 py-6 flex justify-center gap-4 border-t border-gray-200 dark:border-gray-600">
                <x-button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 px-10">
                    {{ __('Guardar') }}
                </x-button>
                <x-secondary-button @click="showModalModificarClientes = false" class="px-10">
                    {{ __('Cancelar') }}
                </x-secondary-button>
            </div>
        </form>

    </div>
</div>