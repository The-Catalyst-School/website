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
import VueToast from 'vue-toast-notification'
import vClickOutside from 'v-click-outside'

import 'vue-toast-notification/dist/theme-default.css';

InertiaProgress.init({
  delay: 25,
  color: '#000',
})

Vue.prototype.$route = route
Vue.use(DayjsPlugin)
Vue.use(Embed)
Vue.use(VueToast);
Vue.use(VueScrollTo, {
  offset: -70,
})
Vue.use(VueDragscroll)
Vue.use(vClickOutside)
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
      methods: {
        setNight() {
          let current = JSON.parse(window.localStorage.getItem('night'))
          if (current) {
            document.body.classList.add('is-night')
          } else {
            document.body.classList.remove('is-night')
          }
        }
      },
      mounted() {
        this.$on('toggle-night', () => {
          let current = JSON.parse(window.localStorage.getItem('night'))
          window.localStorage.setItem(
            'night',
            !current
          )
          this.setNight()
        })
        this.setNight()
      }
    }).$mount(el)
  },
})
