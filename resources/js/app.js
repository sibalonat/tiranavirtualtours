import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";

//pinia
import { createPinia } from "pinia";
const pinia = createPinia();

import { modal } from "momentum-modal";

console.log(modal);

import { vfmPlugin } from 'vue-final-modal'

const appName =
    window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";

createInertiaApp({
    progress: {
        color: "#4B5563",
        delay: 250,
        includeCSS: true,
        showSpinner: true,
    },
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            // .use(modal, {
            //     resolve: (name) =>
            //         resolvePageComponent(
            //             name,
            //             import.meta.glob("./Pages/**/*.vue")
            //         ),
            // })
            .use(plugin)
            .use(vfmPlugin)
            .use(ZiggyVue, Ziggy)
            .use(pinia)
            .mount(el);
    },
});
