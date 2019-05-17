/**
 * Load babies from server before initializing app
 */
export default function({ store }) {
  const babies = store.state.babies.babies
  if (Object.values(babies).length === 0) {
    store.dispatch('babies/getBabies')
  }
}
