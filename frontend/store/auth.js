const STORAGE_TOKEN_KEY = 'token'

export const state = () => ({
  token: undefined,
  profile: {}
})

export const getters = {
  isAuthenticated(state) {
    return state.token !== undefined
  }
}

export const mutations = {
  setToken(state, { token }) {
    window.localStorage.setItem(STORAGE_TOKEN_KEY, token)
  },
  logout(state) {
    window.localStorage.removeItem(STORAGE_TOKEN_KEY)
  },
  setProfile(state, { profile }) {
    state.profile = profile
  },
  clearAll(state) {
    state.profile = {}
    state.token = undefined
  },
  loadFromLocalStorage(state) {
    state.token = window.localStorage.getItem(STORAGE_TOKEN_KEY) || undefined
  }
}

export const actions = {
  authenticate({ commit }, { email, password }) {
    return this.$axios
      .post('users/token', {
        email,
        password
      })
      .then(res => {
        commit('setToken', { token: res.data.data.token })
        commit('loadFromLocalStorage')
        return res
      })
  },
  getProfile({ commit }) {
    return this.$axios.get('users/me').then(res => {
      commit('setProfile', { profile: res.data.data })
      return res
    })
  }
}