import {resolvePageComponent} from "laravel-vite-plugin/inertia-helpers";

import('./bootstrap');

import { createApp, h } from 'vue'
import { createInertiaApp, Link, Head } from '@inertiajs/vue3'
import { Ziggy } from './ziggy';
//import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import moment from "moment/moment";


createInertiaApp({
    resolve: name => resolvePageComponent(
        `/resources/js/components/pages/${name}.vue`,
        import.meta.glob('/resources/js/components/pages/**/*.vue')
    ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .mixin({methods: {route: window.route}})
            .use(VueSweetalert2)
            .use(Ziggy)
            .use(plugin)
            .component('inertia-link', Link)
            .component('Head', Head)
            .mount(el)
    },
    title: title => `Assassin\'s creed Forum - ${title}`
})

