import objectPath from 'object-path'
import { Plugin } from '@nuxt/types'

type ObjectPath = typeof objectPath

declare module 'vue/types/vue' {
  interface Vue {
    readonly $objectPath: ObjectPath
  }
}

declare module '@nuxt/types' {
  interface NuxtAppOptions {
    readonly $objectPath: ObjectPath
  }
}

declare module 'vuex/types/index' {
  interface Store<S> {
    readonly $objectPath: ObjectPath
  }
}

const objectPathPlugin: Plugin = (_, inject) => {
  inject('objectPath', objectPath)
}

export default objectPathPlugin
