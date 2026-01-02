import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: false,
        }),
    ],
    build: {
        manifest: true,          // generate manifest.json
        outDir: 'public/build',  // must be a folder
        emptyOutDir: true,       // clean old builds
    },
});
