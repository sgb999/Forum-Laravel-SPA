import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';
//import('./resources/js/bootstrap');
export default defineConfig({
    plugins: [
        laravel([
            'resources/js/app.js',
        ]),
         vue({
             template: {
                 transformAssetUrls: {
                     base: null,
                     includeAbsolute: false,
                 },
             },
         }),
    ],
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap')
        }
    }
});