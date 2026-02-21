/**
 * Gestión del Modal de Documentar Caso
 */

export function documentarCaso() {
    return {
        searchId: '',
        caso: { 
            id: null, 
            cliente: { nombre: '', apellido: '' }, 
            descripcion_falla: '',
            documentacion: [] 
        },
        piezas: [],
        loading: false,
        error: '',
        entries: [{ piece: '', qty: 1 }],

        init() {
            fetch('/piezas')
                .then(response => response.json())
                .then(data => this.piezas = data);
        },

        buscarCaso() {
            if (!this.searchId) return;
            this.loading = true;
            this.error = '';
            // Reset caso structure
            this.caso = { id: null, cliente: { nombre: '', apellido: '' }, descripcion_falla: '', documentacion: [] };
            
            fetch(`/casos/search/${this.searchId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        this.error = 'Caso no encontrado.';
                    } else {
                        // Asegurar estructura
                        this.caso = {
                            ...this.caso,
                            ...data,
                            cliente: data.cliente || { nombre: '', apellido: '' },
                            documentacion: data.documentacion || []
                        };
                    }
                })
                .catch(err => {
                    this.error = 'Error en la búsqueda';
                })
                .finally(() => this.loading = false);
        }
    };
}

window.documentarCaso = documentarCaso;
