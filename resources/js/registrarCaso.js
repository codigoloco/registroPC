/**
 * Gestión del Modal de Consultar / Modificar Caso
 */

export function registrarCaso() {
    return {
        searchId: '',
        caso: { 
            id: null, 
            cliente: { nombre: '', apellido: '' }, 
            descripcion_falla: '', 
            pieza_sugerida: '',
            forma_de_atencion: 'encomienda',
            estatus: 'asignado',
            documentacion: [] 
        },
        loading: false,
        error: '',

        // Búsqueda Filtrable de Casos
        casos: [],
        showCasosList: false,

        async init() {
            await this.fetchCasos();
        },

        async fetchCasos() {
            try {
                const { data } = await axios.get('/casos/disponibles');
                this.casos = data;
            } catch (error) {
                console.error('Error al cargar casos:', error);
            }
        },

        get filteredCasos() {
            if (!this.searchId) return this.casos.slice(0, 10);
            
            const searchTerm = this.searchId.toString().toLowerCase();
            return this.casos.filter(c => {
                const clienteNombre = `${c.cliente.nombre} ${c.cliente.apellido || ''}`.toLowerCase();
                return c.id.toString().includes(searchTerm) || clienteNombre.includes(searchTerm);
            }).slice(0, 10);
        },

        selectCaso(caso) {
            this.searchId = caso.id;
            this.showCasosList = false;
            this.buscarCaso();
        },

        buscarCaso() {
            if (!this.searchId) return;
            this.loading = true;
            this.error = '';
            
            // Reset to default structure
            this.caso = { 
                id: null, 
                cliente: { nombre: '', apellido: '' }, 
                descripcion_falla: '', 
                pieza_sugerida: '',
                forma_de_atencion: 'encomienda',
                estatus: 'asignado',
                documentacion: [] 
            };

            fetch(`/casos/search/${this.searchId}`, {
                headers: { 'Accept': 'application/json' }
            })
            .then(async response => {
                const data = await response.json();
                if (!response.ok) {
                    throw new Error(data.error || 'Caso no encontrado');
                }
                return data;
            })
            .then(data => {
                this.caso = {
                    ...this.caso,
                    ...data,
                    cliente: data.cliente || { nombre: '', apellido: '' },
                    documentacion: data.documentacion || []
                };
            })
            .catch(err => {
                this.error = err.message;
            })
            .finally(() => this.loading = false);
        }
    };
}

window.registrarCaso = registrarCaso;
