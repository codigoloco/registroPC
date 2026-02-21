/**
 * Control del modal "Casos Asignados".
 * realiza una petición al endpoint /casos/asignados y guarda el resultado
 * en un arreglo para mostrarlo en la tabla.
 */

export function initCasosAsignadosModal() {
    return {
        casos: [],
        loading: false,

        init() {
            // cargar al inicio y también permitir recargas manuales mediante evento
            this.loadCasos();
            this.$on('refresh-assigned-cases', () => {
                this.loadCasos();
            });
        },

        async loadCasos() {
            this.loading = true;
            try {
                const response = await axios.get('/casos/asignados');
                this.casos = response.data;
            } catch (err) {
                console.error('Error cargando casos asignados:', err);
                this.casos = [];
            } finally {
                this.loading = false;
            }
        }
    };
}

window.initCasosAsignadosModal = initCasosAsignadosModal;
