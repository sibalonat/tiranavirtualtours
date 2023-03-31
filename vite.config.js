import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
// import { VitePWA } from 'vite-plugin-pwa';
import mkcert from "vite-plugin-mkcert";
import { chunkSplitPlugin } from 'vite-plugin-chunk-split';
import path from 'path';
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
        // VitePWA({
        //     registerType: 'autoUpdate',
        //     selfDestroying: true,
        //     // outDir: 'public/build'
        //     outDir: path.resolve(__dirname, 'public'),
        //     buildBase: '/',
        //     scope: '/',
        //     base: '/',
        //     // buildBase: '/build/',
        //     // scope: '/',
        //     injectRegister: 'auto',
        //     // workbox: {
        //     //     sourcemap: true
        //     // },
        //     workbox: {
        //         globDirectory: path.resolve(__dirname, 'public'),
        //         swDest       : 'public/sw.js',
        //         globPatterns : [
        //             '{build,images,sounds}/**/*.{js,css,html,ico,png,jpg,mp4,svg}'
        //         ],
        //         // globPatterns: ['**/*.{js,css,ico,png,svg}'],
        //         cleanupOutdatedCaches: false,
        //         runtimeCaching: [
        //             {
        //                 urlPattern: '/^\/app\/$/',
        //                 handler: 'NetworkFirst',
        //                 options: {
        //                     cacheName: 'app',
        //                     expiration: {
        //                         maxEntries: 10,
        //                         maxAgeSeconds: 60 * 60 * 24 * 365 // <== 365 days
        //                     },
        //                     cacheableResponse: {
        //                         statuses: [200]
        //                     },
        //                 }
        //             }
        //         ]
        //     },
        //     manifest: {
        //         name: 'My Awesome App',
        //         short_name: 'MyApp',
        //         description: 'My Awesome App description',
        //         theme_color: '#ffffff',
        //         icons: [
        //             {
        //                 src: '/images/pwa-192x192.png',
        //                 sizes: '192x192',
        //                 type: 'image/png'
        //             },
        //             {
        //                 src: '/images/pwa-512x512.png',
        //                 sizes: '512x512',
        //                 type: 'image/png',
        //                 purpose: "any maskable"
        //             }
        //         ]
        //     } // your manifest to pwa with your icons and names
        // }),
        mkcert(),
        chunkSplitPlugin()
    ],
    build: {
        chunkSizeWarningLimit: 1600,
        emptyOutDir: true,
        rollupOptions: {
            output: {
                entryFileNames: "[name].js",
                chunkFileNames: "[name].js",
                assetFileNames: "[name].[ext]",
            },
        },
    },
    ssr: {
        noExternal: [
            '@inertiajs/server',
            'laravel-vite-plugin',
        ],
    },
});
