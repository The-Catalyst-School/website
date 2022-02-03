import Vue from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue'
import { InertiaProgress } from '@inertiajs/progress'
import DayjsPlugin from './plugins/dayjs'
import dateFormat from './filters/dateFormat'
import SlideUpDown from 'vue-slide-up-down'
import Layout from './Layouts/Main'

InertiaProgress.init({
  delay: 25,
  color: '#000',
})

Vue.prototype.$route = route
Vue.use(DayjsPlugin)
Vue.component('slide-up-down', SlideUpDown)

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
