require('./bootstrap');

import { createApp, h } from 'vue'
import { createInertiaApp, Link, Head } from '@inertiajs/inertia-vue3'
import { Ziggy } from './ziggy';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

const $ = x => {
    if(x.startsWith('.')) {
        document.getElementsByClassName(x);
    }
    else if(x.startsWith('#')) {
        document.getElementById(x);
    }
    else {
        document.getElementsByTagName(x);
    }
};
createInertiaApp({
    resolve: name => require(`./components/pages/${name}`),
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

