/**
 * Gestión del Modal de Crear Caso
 * Maneja la búsqueda de clientes y carga de piezas disponibles
 */

export function initCrearCasoModal() {
    return {
        searchCedula: '',
        cliente: null,
        loading: false,
        error: '',
        piezas: [],
        loadingPiezas: false,

        /**
         * Inicializa el componente cargando las piezas disponibles
         */
        init() {
            this.cargarPiezas();
        },

        /**
         * Carga las piezas disponibles desde el servidor usando axios
         */
        async cargarPiezas() {
            this.loadingPiezas = true;
            try {
                const response = await axios.get('/piezas');
                this.piezas = response.data;
            } catch (err) {
                console.error('Error al cargar piezas:', err);
                this.piezas = [];
            } finally {
                this.loadingPiezas = false;
            }
        },

        /**
         * Busca un cliente por su cédula/RIF usando axios
         */
        async buscarCliente() {
            if (!this.searchCedula) return;
            
            this.loading = true;
            this.error = '';
            this.cliente = null;

            try {
                const response = await axios.get(`/clientes/search/${this.searchCedula}`);
                this.cliente = response.data;
            } catch (err) {
                // Axios coloca el mensaje de error en err.response.data
                this.error = err.response?.data?.error || err.message || 'Cliente no encontrado';
                this.cliente = null;
            } finally {
                this.loading = false;
            }
        }
    };
}

// Hacer disponible globalmente para Alpine.js
window.initCrearCasoModal = initCrearCasoModal;
