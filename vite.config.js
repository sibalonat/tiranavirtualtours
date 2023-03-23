import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import mkcert from "vite-plugin-mkcert";
import { chunkSplitPlugin } from 'vite-plugin-chunk-split';
export default defineConfig({
    server: {
        https: true,
        host: "localhost",
        hmr: {
            host: "localhost",
        },
        // hmr: {
        //     clientPort: 27,
        //   },
    },
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            ssr: "resources/js/ssr.js",
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        mkcert(),
        chunkSplitPlugin()
    ],
    build: {
        chunkSizeWarningLimit: 1600,
    },
    ssr: {
        noExternal: [
            '@inertiajs/server',
            'laravel-vite-plugin',
        ],
    },
});
