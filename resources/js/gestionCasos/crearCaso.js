/**
 * Gestión del Modal de Crear Caso
 */

export function initCrearCasoModal() {
    return {
        searchCedula: '',
        cliente: { nombre: '', apellido: '' }, // Objeto inicializado para evitar errores null
        clientFound: false, // Flag para visibilidad
        loading: false,
        error: '',
        piezas: [],
        loadingPiezas: false,

        init() {
            this.cargarPiezas();
        },

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

        async buscarCliente() {
            if (!this.searchCedula) return;
            
            this.loading = true;
            this.error = '';
            this.clientFound = false;
            this.cliente = { nombre: '', apellido: '' };

            try {
                const response = await axios.get(`/clientes/search/${this.searchCedula}`);
                this.cliente = response.data;
                this.clientFound = true;
            } catch (err) {
                this.error = err.response?.data?.error || err.message || 'Cliente no encontrado';
            } finally {
                this.loading = false;
            }
        }
    };
}

window.initCrearCasoModal = initCrearCasoModal;
