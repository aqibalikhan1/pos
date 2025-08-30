import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/blade-app.js',
                 'resources/css/material-theme.css',
                 'resources/css/datatables.css',
                 'resources/js/datatables.js',
                 'resources/js/pos-terminal.js'
            ],
            ssr: 'resources/js/ssr.js',
            refresh: true, // Set to false for production
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
