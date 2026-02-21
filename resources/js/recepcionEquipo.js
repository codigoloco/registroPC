/**
 * Gestión del Modal de Recepción de Equipo
 */

export function recepcionEquipo() {
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

        // Búsqueda Filtrable de Equipos
        equipos: [],
        searchEquipo: '',
        selectedEquipoId: '',
        showEquiposList: false,

        async init() {
            await Promise.all([
                this.fetchCasos(),
                this.fetchEquipos()
            ]);
        },

        async fetchCasos() {
            try {
                const { data } = await axios.get('/casos/disponibles');
                this.casos = data;
            } catch (error) {
                console.error('Error al cargar casos:', error);
            }
        },

        async fetchEquipos() {
            try {
                const { data } = await axios.get('/equipos/all');
                this.equipos = data;
            } catch (error) {
                console.error('Error al cargar equipos:', error);
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

        get filteredEquipos() {
            if (!this.searchEquipo) return this.equipos.slice(0, 10);
            
            const searchTerm = this.searchEquipo.toString().toLowerCase();
            return this.equipos.filter(e => {
                const modeloNombre = (e.modelo?.nombre || '').toLowerCase();
                const tipoNombre = (e.tipo?.nombre || '').toLowerCase();
                const serial = (e.serial_equipo || '').toLowerCase();
                return e.id.toString().includes(searchTerm) || 
                       modeloNombre.includes(searchTerm) || 
                       tipoNombre.includes(searchTerm) || 
                       serial.includes(searchTerm);
            }).slice(0, 10);
        },

        selectCaso(caso) {
            this.selectedCasoId = caso.id;
            this.searchCaso = `#${caso.id} - ${caso.cliente.nombre} ${caso.cliente.apellido || ''}`;
            this.showCasosList = false;
        },

        selectEquipo(equipo) {
            this.selectedEquipoId = equipo.id;
            this.searchEquipo = `${equipo.tipo?.nombre} ${equipo.modelo?.nombre} (${equipo.serial_equipo})`;
            this.showEquiposList = false;
        },

        async fetchHistorial(url = '/recepcion/all') {
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

window.recepcionEquipo = recepcionEquipo;
