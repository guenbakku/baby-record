import Vue from 'vue'
import VueMoment from 'vue-moment'
import moment from 'moment-timezone'
import { Plugin } from '@nuxt/types'

export type Moment = (
  inp?:
    | string
    | number
    | void
    | moment.Moment
    | Date
    | (string | number)[]
    | moment.MomentInputObject
    | undefined,
  format?:
    | string
    | moment.MomentBuiltinFormat
    | (string | moment.MomentBuiltinFormat)[]
    | undefined,
  strict?: boolean | undefined
) => moment.Moment

declare module '@nuxt/types' {
  interface NuxtAppOptions {
    $moment: Moment
  }
}

declare module 'vuex/types/index' {
  interface Store<S> {
    $moment: Moment
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
