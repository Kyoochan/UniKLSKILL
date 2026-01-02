import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: false, // only needed for dev
        }),
    ],
    build: {
        manifest: true,         // Generate manifest.json for Laravel
        outDir: 'public/build', // Output directory must match Blade usage
        emptyOutDir: true,      // Clean old builds
    },
});
