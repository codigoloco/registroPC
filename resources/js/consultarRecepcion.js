/**
 * Gestión del Modal de Consulta/Modificación de Recepción
 */

export function consultarRecepcion() {
    return {
        idCasoSearch: '',
        recepcion: {
            id_equipo: '',
            tipo_atencion: 'presupuesto',
            pago: '',
            falla_tecnica: '',
            deposito: 'Tecnico',
            fecha_recepcion: '-',
            fecha_salida: '-'
        },
        loading: false,
        error: '',

        // Búsqueda Filtrable de Casos
        casos: [],
        searchCasoInput: '',
        showCasosList: false,

        // Búsqueda Filtrable de Equipos
        equipos: [],
        searchEquipo: '',
        showEquiposList: false,

        async init() {
            await Promise.all([
                this.fetchCasos(),
                this.fetchEquipos()
            ]);
        },

        async fetchCasos() {
            try {
                // Traemos todos los casos para poder buscarlos
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
            if (!this.searchCasoInput) return this.casos.slice(0, 10);
            
            const searchTerm = this.searchCasoInput.toString().toLowerCase();
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

        selectCasoParaBusqueda(caso) {
            this.idCasoSearch = caso.id;
            this.searchCasoInput = `#${caso.id} - ${caso.cliente.nombre} ${caso.cliente.apellido || ''}`;
            this.showCasosList = false;
            this.buscarPorCaso();
        },

        selectEquipo(equipo) {
            this.recepcion.id_equipo = equipo.id;
            this.searchEquipo = `${equipo.tipo?.nombre} ${equipo.modelo?.nombre} (${equipo.serial_equipo})`;
            this.showEquiposList = false;
        },

        buscarPorCaso() {
            if (!this.idCasoSearch) return;
            this.loading = true;
            this.error = '';
            
            fetch(`/recepcion/search/${this.idCasoSearch}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        this.error = data.error;
                        this.recepcion = { id_equipo: '', tipo_atencion: 'presupuesto', pago: '', falla_tecnica: '', deposito: 'Tecnico', fecha_recepcion: '-', fecha_salida: '-' };
                        this.searchEquipo = '';
                    } else {
                        this.recepcion = data;
                        // Al cargar, buscar el equipo para llenar el buscador visual
                        if (this.recepcion.id_equipo) {
                            const eq = this.equipos.find(e => e.id == this.recepcion.id_equipo);
                            if (eq) {
                                this.searchEquipo = `${eq.tipo?.nombre} ${eq.modelo?.nombre} (${eq.serial_equipo})`;
                            } else {
                                this.searchEquipo = `ID: ${this.recepcion.id_equipo}`;
                            }
                        }
                    }
                })
                .catch(err => {
                    this.error = 'Error al consultar';
                    console.error(err);
                })
                .finally(() => this.loading = false);
        }
    };
}

window.consultarRecepcion = consultarRecepcion;
