/**
 * Load data from server before initializing app
 */
export default function({ store }) {
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
