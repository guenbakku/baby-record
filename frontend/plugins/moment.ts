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

const userLang = 'vi'
moment.tz(moment.tz.guess())
moment.locale(userLang)
Vue.use(VueMoment, {
  moment
})

const momentPlugin: Plugin = ({ store }, inject) => {
  inject('moment', moment)
  store.commit('config/setLocale', { value: moment.locale() })
}

export default momentPlugin
