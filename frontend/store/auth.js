const STORAGE_TOKEN_KEY = 'token'

export const state = () => ({
  profile: {}
})

export const getters = {
  token(state) {
    return window.localStorage.getItem(STORAGE_TOKEN_KEY) || undefined
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
