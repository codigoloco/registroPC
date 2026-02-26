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
            this.fetchData();
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

        formatAccion(accion) {
            const mapping = {
                'INSERT': 'Creación',
                'UPDATE': 'Actualización',
                'DELETE': 'Eliminación',
                'DOCUMENTAR': 'Documentación Técnica',
                'INSERT_RECEPCION_AUTO_ASIGNACION': 'Recepción y Asignación Automática',
                'LOGIN': 'Inicio de Sesión',
                'LOGOUT': 'Cierre de Sesión',
                'REGISTRAR_ENTREGA': 'Registro de Entrega',
                'UPDATE_RECEPCION': 'Registro de Recepción',
                'INSERT_SALIDA': 'Registro de Salida',
                'INSERT_EQUIPO': 'Registro de Equipo',
                'INSERT_CLIENTE': 'Registro de Cliente',
                'INSERT_USER': 'Creación de Usuario',
                'UPDATE_USER': 'Modificación de Usuario'
            };
            return mapping[accion] || accion;
        },

        truncateJSON(json) {
            if (!json) return 'N/A';
            const str = typeof json === 'string' ? json : JSON.stringify(json);
            return str.length > 50 ? str.substring(0, 50) + '...' : str;
        },

        renderDiff(inicial, final) {
            const parse = (val) => {
                if (!val) return {};
                if (typeof val === 'object') return val;
                try { return JSON.parse(val); } catch (e) { return {}; }
            };

            const formatValue = (val, key = null) => {
                if (val === undefined || val === null) return '<span class="italic opacity-50 text-gray-400 font-sans">Vacío</span>';
                if (typeof val === 'object') return `<pre class="text-[9px] leading-tight">${JSON.stringify(val, null, 2)}</pre>`;
                
                if (key === 'id_rol') {
                    const roles = {1: 'Administrador', 2: 'Soporte', 3: 'Recepcionista', 4: 'Supervisor'};
                    return roles[val] ? `${roles[val]} (ID: ${val})` : val;
                }
                if (key === 'id_estatus') {
                    const estatus = {1: 'Activo', 2: 'Inactivo', 3: 'Vacaciones', 4: 'Jubilado'};
                    return estatus[val] ? `${estatus[val]} (ID: ${val})` : val;
                }
                
                return val;
            };

            const objInit = parse(inicial);
            const objFinal = parse(final);
            const isInsertion = Object.keys(objInit).length === 0;

            let html = '<div class="mt-4 text-[11px] text-left overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">';
            html += '<table class="w-full border-collapse divide-y divide-gray-200 dark:divide-gray-700">';
            html += '<thead class="bg-blue-600 text-white">';

            if (isInsertion) {
                html += '<tr><th class="px-4 py-2 text-left font-bold uppercase tracking-wider w-1/3">Campo Registrado</th><th class="px-4 py-2 text-left font-bold uppercase tracking-wider w-2/3">Información Guardada</th></tr></thead>';
            } else {
                html += '<tr><th class="px-4 py-2 text-left font-bold uppercase tracking-wider w-1/4">Campo</th><th class="px-4 py-2 text-left font-bold uppercase tracking-wider w-3/8 text-red-100">Estado Anterior</th><th class="px-4 py-2 text-left font-bold uppercase tracking-wider w-3/8 text-green-100">Estado Nuevo</th></tr></thead>';
            }

            html += '<tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">';

            const allKeys = new Set([...Object.keys(objInit), ...Object.keys(objFinal)]);
            const excludedKeys = ['created_at', 'updated_at', 'id', 'deleted_at'];

            let hasChanges = false;

            allKeys.forEach(key => {
                if (excludedKeys.includes(key)) return;

                const valInit = objInit[key];
                const valFinal = objFinal[key];

                if (JSON.stringify(valInit) !== JSON.stringify(valFinal)) {
                    hasChanges = true;
                    if (isInsertion) {
                        html += `<tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <td class="px-4 py-2 font-semibold text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-900/50 capitalize">${key.replace(/_/g, ' ')}</td>
                            <td class="px-4 py-2 font-mono text-green-700 dark:text-green-400 break-all bg-green-50/20 dark:bg-green-900/10">
                                ${formatValue(valFinal, key)}
                            </td>
                        </tr>`;
                    } else {
                        html += `<tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <td class="px-4 py-2 font-semibold text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-900/50 capitalize">${key.replace(/_/g, ' ')}</td>
                            <td class="px-4 py-2 font-mono text-red-600 dark:text-red-400 break-all bg-red-50/30 dark:bg-red-900/10">
                                ${formatValue(valInit, key)}
                            </td>
                            <td class="px-4 py-2 font-mono text-green-600 dark:text-green-400 break-all bg-green-50/30 dark:bg-green-900/10">
                                ${formatValue(valFinal, key)}
                            </td>
                        </tr>`;
                    }
                }
            });

            if (!hasChanges) {
                html += `<tr><td colspan="${isInsertion ? 2 : 3}" class="px-4 py-8 text-center text-gray-500 italic">No se detectaron datos adicionales para mostrar.</td></tr>`;
            }

            html += '</tbody></table></div>';
            return html;
        },

        showDetail(item) {
            const contentHtml = `
                <div class="text-left space-y-4">
                    <div class="flex items-center justify-between p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-100 dark:border-blue-800">
                        <div>
                            <p class="text-[9px] uppercase font-bold text-blue-600 dark:text-blue-400 tracking-wider">Acción Realizada</p>
                            <p class="text-base font-bold text-gray-800 dark:text-white">${this.formatAccion(item.sentencia)}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[9px] uppercase font-bold text-blue-600 dark:text-blue-400 tracking-wider">Dirección IP</p>
                            <p class="text-xs font-mono text-gray-600 dark:text-gray-400">${item.ip}</p>
                        </div>
                    </div>
                    ${this.renderDiff(item.estado_inicial, item.estado_final)}
                    <p class="text-[10px] text-gray-400 text-center mt-4 italic">Auditoría Registro #${item.id} - ${this.formatDate(item.created_at)}</p>
                </div>
            `;

            Swal.fire({
                title: `<span class="text-gray-800 dark:text-white">Detalle de Auditoría</span>`,
                html: contentHtml,
                width: 850,
                confirmButtonText: 'Cerrar ventana',
                confirmButtonColor: '#2563eb',
                background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff'
            });
        }
    }));
});
