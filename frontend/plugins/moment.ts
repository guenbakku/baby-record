import Vue from 'vue'
import VueMoment from 'vue-moment'
import moment from 'moment-timezone'
import { Plugin } from '@nuxt/types'

type Moment = typeof moment

declare module '@nuxt/types' {
  interface NuxtAppOptions {
    readonly $moment: Moment
  }
}

declare module 'vuex/types/index' {
  interface Store<S> {
    readonly $moment: Moment
  }
}

const userLang = navigator.language
moment.tz(moment.tz.guess())
moment.locale(userLang)
Vue.use(VueMoment, {
  moment
})

const momentPlugin: Plugin = (_, inject) => {
  inject('moment', moment)
}

export default momentPlugin
