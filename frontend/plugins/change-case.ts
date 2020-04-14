import changeCase from 'change-case'
import { Plugin } from '@nuxt/types'

type ChangeCase = typeof changeCase

declare module 'vue/types/vue' {
  interface Vue {
    readonly $changeCase: ChangeCase
  }
}

declare module '@nuxt/types' {
  interface NuxtAppOptions {
    readonly $changeCase: ChangeCase
  }
}

declare module 'vuex/types/index' {
  interface Store<S> {
    readonly $changeCase: ChangeCase
  }
}

const changeCasePlugin: Plugin = (_, inject) => {
  inject('changeCase', changeCase)
}

export default changeCasePlugin
