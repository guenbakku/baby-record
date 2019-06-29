/**
 * Initialize app data
 */
export default function({ store }) {
  store.commit('babies/loadFromLocalStorage')
  store.commit('auth/loadFromLocalStorage')

  const isAuthenticated = store.getters['auth/isAuthenticated']
  if (!isAuthenticated) {
    return
  }

  const profile = store.state.auth.profile
  if (Object.values(profile).length === 0) {
    store.dispatch('auth/getProfile')
  }

  const babies = store.state.babies.babies
  if (Object.values(babies).length === 0) {
    store.dispatch('babies/getBabies')
  }
}
