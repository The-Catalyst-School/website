import Vue from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue'
import { InertiaProgress } from '@inertiajs/progress'

import Layout from './Layouts/Main'

InertiaProgress.init({
  delay: 25
})

Vue.prototype.$route = route


createInertiaApp({
  resolve: name => {
    const page = require(`./Pages/${name}`).default
    page.layout = page.layout || Layout
    return page
  },
  setup({ el, App, props }) {
    new Vue({
      render: h => h(App, props),
    }).$mount(el)
  },
})
