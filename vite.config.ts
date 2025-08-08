import crypto from 'crypto';

// Patch correct : crypto.hash doit retourner une string
if (!(crypto as any).hash) {
    (crypto as any).hash = (algo: string, data: string) =>
        crypto.createHash(algo).update(data).digest('hex');
}

import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.ts'],
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        tailwindcss(),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    server: {
        host: '0.0.0.0',
        port: 5174,
        strictPort: true,
        hmr: {
            host: 'localhost',
            port: 5174,
        },
        cors: true,
        headers: {
            'Cache-Control': 'no-store, no-cache, must-revalidate, proxy-revalidate',
            'Pragma': 'no-cache',
            'Expires': '0',
        },
    },
    ssr: {
        noExternal: ['@vue/server-renderer', '@vue/runtime-core'],
    },
});
