import { Middleware } from '@nuxt/types'

/**
 * Auth middleware
 */
const authMiddleware: Middleware = ({ store, redirect, route }) => {
  store.commit('auth/loadFromLocalStorage')

  const isAuthenticated = store.getters['auth/isAuthenticated']
  if (!isAuthenticated) {
    if (route.name !== 'login') {
      redirect('/login')
    }
  } else {
    const profile = store.state.auth.profile
    if (!profile) {
      store.dispatch('auth/getProfile')
    }
  }
}

export default authMiddleware
