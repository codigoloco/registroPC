/**
 * Gestión del Modal de Asignación de Técnicos
 */

export function asignarTecnico() {
    return {
        loading: false,
        
        // Búsqueda Filtrable de Casos
        casos: [],
        searchCaso: '',
        selectedCasoId: '',
        showCasosList: false,

        // Técnicos
        tecnicos: [],
        selectedTecnicoId: '',

        async init() {
            await Promise.all([
                this.fetchCasos(),
                this.fetchTecnicos()
            ]);
        },

        async fetchCasos() {
            try {
                // Traemos los casos disponibles (no entregados)
                const { data } = await axios.get('/casos/disponibles');
                this.casos = data;
            } catch (error) {
                console.error('Error al cargar casos:', error);
            }
        },

        async fetchTecnicos() {
            try {
                const { data } = await axios.get('/tecnicos/all');
                this.tecnicos = data;
            } catch (error) {
                console.error('Error al cargar técnicos:', error);
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
    };
}

window.asignarTecnico = asignarTecnico;
