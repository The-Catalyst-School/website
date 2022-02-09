import Vue from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue'
import { InertiaProgress } from '@inertiajs/progress'
import DayjsPlugin from './plugins/dayjs'
import Embed from 'v-video-embed'
import VueScrollTo from 'vue-scrollto'
import dateFormat from './filters/dateFormat'
import paddingZero from './filters/paddingZero'
import SlideUpDown from 'vue-slide-up-down'
import Layout from './Layouts/Main'
import Sticky from 'vue-sticky-directive/src/sticky'
import VueDragscroll from 'vue-dragscroll'

InertiaProgress.init({
  delay: 25,
  color: '#000',
})

Vue.prototype.$route = route
Vue.use(DayjsPlugin)
Vue.use(Embed)
Vue.use(VueScrollTo, {
  offset: -70,
})
Vue.use(VueDragscroll)
Vue.directive('Sticky', Sticky);
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
