const STORAGE_CURRENT_BABY_ID = 'current_baby_id'

export const state = () => ({
  current: undefined,
  babies: {}
})

export const getters = {
  getCurrent (state) {
    let currentId

    currentId = state.current
    if(currentId && state.babies[currentId]) {
      return state.babies[currentId]
    }

    currentId = window.localStorage.getItem(STORAGE_CURRENT_BABY_ID)
    if(currentId && state.babies[currentId]) {
      return state.babies[currentId]
    }

    if (state.babies) {
      const firstId = Object.keys(state.babies)[0]
      return state.babies[firstId]
    }

    return {}
  },

  getBabies (state) {
    return state.babies
  }
}

export const mutations = {
  setCurrent (state, { id }) {
    window.localStorage.setItem(STORAGE_CURRENT_BABY_ID, id)
    state.current = id
  },
  setBabies (state, { babies }) {
    const data = {}
    for (const baby of babies) {
      // TODO: remove this line
      baby.avatar = 'https://vuetifyjs.com/apple-touch-icon-180x180.png'
      data[baby.id] = baby
    }
    state.babies = data
  }
}

export const actions = {
  getBabies ({ commit }) {
    return this.$axios.get('babies')
      .then(function (res) {
        commit('setBabies', { babies: res.data.data })
      })
  }
}
