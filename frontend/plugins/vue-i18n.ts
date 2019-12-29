import Vue from 'vue'
import VueI18n from 'vue-i18n'
import { Plugin } from '@nuxt/types'
import vi from '../i18n/vi.json'

Vue.use(VueI18n)
const messages = { vi }

declare module '@nuxt/types' {
  interface NuxtAppOptions {
    readonly $i18n: VueI18n
  }
}

declare module 'vuex/types/index' {
  interface Store<S> {
    readonly $i18n: VueI18n
  }
}

const i18nPlugin: Plugin = (_, inject) => {
  inject(
    'i18n',
    new VueI18n({
      locale: 'vi',
      messages
    })
  )
}

export default i18nPlugin
