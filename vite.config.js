import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/dashboard.css',
                'resources/js/dashboard.js',
                'resources/js/gestionAuditoria.js',
                'resources/js/gestionCasos/crearCaso.js',
                'resources/js/documentarCaso.js',
                'resources/js/registrarCaso.js',
                'resources/js/recepcionEquipo.js',
                'resources/js/consultarRecepcion.js',
                'resources/js/registrarSalida.js',
                'resources/js/asignarTecnico.js',
            ],
            refresh: true,
        }),
    ],
});
