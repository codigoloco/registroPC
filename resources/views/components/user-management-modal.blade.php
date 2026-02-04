<div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0">

    <!-- Fondo Oscuro (Backdrop) -->
    <div x-show="showModal" class="fixed inset-0 transform transition-all" x-on:click="showModal = false"
        x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
    </div>

    <!-- Panel del Modal -->
    <div x-show="showModal"
        class="mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-4xl sm:mx-auto"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-data="{
            searchEmail: '',
            user: {
                name: '',
                lastname: '',
                email: '',
                role: '',
                id_estatus: ''
            },
            loading: false,
            error: '',
            buscarUsuario() {
                if (!this.searchEmail) return;
                this.loading = true;
                this.error = '';
                fetch(`/users/search/${this.searchEmail}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            this.error = data.error;
                            this.user = { name: '', lastname: '', email: '', role: '', id_estatus: '' };
                        } else {
                            this.user = data;
                        }
                    })
                    .catch(err => {
                        this.error = 'Error al buscar';
                        console.error(err);
                    })
                    .finally(() => this.loading = false);
            }
        }">

        <!-- Encabezado del Formulario -->
        <div class="bg-blue-600 text-white px-6 py-4 flex items-center shadow-sm justify-between">
            <div class="flex items-center">
                <span class="text-lg font-semibold">{{ __('Modificar Usuario') }}</span>
            </div>
            <button @click="showModal = false" class="text-white hover:text-gray-200 focus:outline-none">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form action="{{ route('users.update') }}" method="POST">
            @csrf
            <input type="hidden" name="email" :value="user.email">
            <div class="p-8 space-y-8">
                <x-user-management-form />
            </div>

            <!-- Footer de Acciones -->
            <div
                class="bg-gray-50 dark:bg-gray-700 px-6 py-6 flex justify-center gap-4 border-t border-gray-200 dark:border-gray-600">
                <x-button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 active:bg-blue-800 border-blue-600 focus:ring-blue-500 px-10">
                    {{ __('Guardar Cambios') }}
                </x-button>
                <x-secondary-button class="px-10" @click="showModal = false">
                    {{ __('Cancelar') }}
                </x-secondary-button>
            </div>
        </form>

    </div>
</div>