/**
 * Load babies from server before initializing app
 */
export default function({ store, $nuxt }) {
  window.console.log($nuxt)
  store.dispatch('babies/getBabies')
}
