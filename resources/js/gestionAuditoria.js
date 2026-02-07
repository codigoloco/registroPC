import axios from 'axios';

document.addEventListener('alpine:init', () => {
    Alpine.data('gestionAuditoria', () => ({
        auditorias: [],
        loading: false,
        currentPage: 1,
        lastPage: 1,
        filters: {
            usuario: '',
            id_caso: '',
            fecha_inicio: '',
            fecha_fin: ''
        },

        init() {
            this.$watch('showAuditoriaModal', value => {
                if (value && this.auditorias.length === 0) {
                    this.fetchData();
                }
            });
        },

        async fetchData(page = 1) {
            this.loading = true;
            try {
                const params = {
                    page,
                    ...this.filters
                };
                const response = await axios.get('/api/auditoria/data', { params });
                this.auditorias = response.data.data;
                this.currentPage = response.data.current_page;
                this.lastPage = response.data.last_page;
            } catch (error) {
                console.error('Error fetching auditoria data:', error);
            } finally {
                this.loading = false;
            }
        },

        limpiarFiltros() {
            this.filters = {
                usuario: '',
                id_caso: '',
                fecha_inicio: '',
                fecha_fin: ''
            };
            this.fetchData();
        },

        formatDate(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            return date.toLocaleString();
        },

        truncateJSON(json) {
            if (!json) return 'N/A';
            const str = typeof json === 'string' ? json : JSON.stringify(json);
            return str.length > 50 ? str.substring(0, 50) + '...' : str;
        },

        showDetail(item) {
            alert(`Detalle Auditoria #${item.id}\n\nAcción: ${item.sentencia}\nIP: ${item.ip}\n\nEstado Inicial: ${JSON.stringify(item.estado_inicial, null, 2)}\n\nEstado Final: ${JSON.stringify(item.estado_final, null, 2)}`);
        }
    }));
});
