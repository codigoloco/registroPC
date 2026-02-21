/**
 * Gestión del Modal de Registrar Salida de Equipo
 */

export function registrarSalida() {
    return {
        showHistorial: false,
        historial: [],
        pagination: {},
        loading: false,
        
        // Búsqueda Filtrable de Casos
        casos: [],
        searchCaso: '',
        selectedCasoId: '',
        showCasosList: false,

        async init() {
            await this.fetchCasos();
        },

        async fetchCasos() {
            try {
                // Solo casos que NO estén entregados para registrar salida
                const { data } = await axios.get('/casos/disponibles');
                this.casos = data;
            } catch (error) {
                console.error('Error al cargar casos:', error);
            }
        },

        get filteredCasos() {
            if (!this.searchCaso) return this.casos.slice(0, 10);
            
            const searchTerm = this.searchCaso.toString().toLowerCase();
            return this.casos.filter(c => {
                const clienteNombre = `${c.cliente.nombre} ${c.cliente.apellido || ''}`.toLowerCase();
                return c.id.toString().includes(searchTerm) || clienteNombre.includes(searchTerm);
            }).slice(0, 10);
        },

        selectCaso(caso) {
            this.selectedCasoId = caso.id;
            this.searchCaso = `#${caso.id} - ${caso.cliente.nombre} ${caso.cliente.apellido || ''}`;
            this.showCasosList = false;
        },

        async fetchHistorial(url = '/salida/all') {
            this.loading = true;
            try {
                const { data } = await axios.get(url);
                this.historial = data.data;
                this.pagination = data;
                this.showHistorial = true;
            } catch (error) {
                console.error('Error al cargar historial:', error);
            } finally {
                this.loading = false;
            }
        }
    };
}

window.registrarSalida = registrarSalida;
