import titleMixin from "@/Mixins/titleMixin";
import timeline from "@/timeline";
import slider from "@/slider";
import Vue from 'vue';
import '@fortawesome/fontawesome-free/js/all.min';
import 'vue-multiselect/dist/vue-multiselect.min.css';

window._ = require('lodash');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import { InertiaApp } from '@inertiajs/inertia-vue';
import { InertiaForm } from 'laravel-jetstream';

if (document.querySelector('.timeline')) {
    timeline();
}

if (document.querySelector('.music')) {
    slider();
}

if (document.querySelector('.contact')) {
    Vue.component('contact-form', require('./Pages/ContactForm.vue').default);
    new Vue({
        el: '.contact'
    })
}

const app = document.getElementById('app');

if (app) {
    Vue.mixin({ methods: { route } });
    Vue.mixin(titleMixin());
    Vue.use(InertiaApp);
    Vue.use(InertiaForm);

    new Vue({
        render: (h) =>
            h(InertiaApp, {
                props: {
                    initialPage: JSON.parse(app.dataset.page),
                    resolveComponent: (name) => require(`./Pages/${name}`).default,
                },
            }),
    }).$mount(app);
}

