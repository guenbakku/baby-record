/**
 * Baby middleware
 */
export default function({ store }) {
  const isAuthenticated = store.getters['auth/isAuthenticated']
  if (!isAuthenticated) {
    return
  }

  store.commit('babies/loadFromLocalStorage')

  const babies = store.state.babies.babies
  if (Object.values(babies).length === 0) {
    store.dispatch('babies/getBabies')
  }
}
