/**
 * Baby middleware
 */
export default function({ store, redirect, route }) {
  const isAuthenticated = store.getters['auth/isAuthenticated']
  if (!isAuthenticated) {
    return
  }

  store.commit('babies/loadFromLocalStorage')

  const babies = store.state.babies.babies
  if (Object.values(babies).length === 0) {
    store.dispatch('babies/getBabies').then(res => {
      if (res.data.data.length === 0 && route.name !== 'babies-add') {
        redirect(302, { name: 'babies' })
      }
    })
  }
}
