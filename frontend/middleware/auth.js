/**
 * Auth middleware
 */
export default function({ store, redirect, route }) {
  store.commit('auth/loadFromLocalStorage')

  const isAuthenticated = store.getters['auth/isAuthenticated']
  if (!isAuthenticated) {
    if (route.name !== 'login') {
      redirect('/login')
    }
  } else {
    const profile = store.state.auth.profile
    if (Object.values(profile).length === 0) {
      store.dispatch('auth/getProfile')
    }
  }
}
