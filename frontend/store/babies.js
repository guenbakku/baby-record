const STORAGE_CURRENT_BABY_ID = 'current_baby_id'

export const state = () => ({
  currentId: undefined,
  babies: {}
})

export const getters = {
  current(state) {
    const currentId = state.currentId
    if (currentId && state.babies[currentId]) {
      return state.babies[currentId]
    }

    if (state.babies) {
      const firstId = Object.keys(state.babies)[0]
      return state.babies[firstId]
    }

    return undefined
  }
}

export const mutations = {
  setCurrentId(state, { id }) {
    window.localStorage.setItem(STORAGE_CURRENT_BABY_ID, id)
    state.currentId = id
  },
  setBabies(state, { babies }) {
    const data = {}
    for (const baby of babies) {
      // TODO: remove this line
      baby.avatar = 'https://vuetifyjs.com/apple-touch-icon-180x180.png'
      data[baby.id] = baby
    }
    state.babies = data
  },
  clearAll(state) {
    state.babies = {}
  },
  loadFromLocalStorage(state) {
    state.currentId =
      window.localStorage.getItem(STORAGE_CURRENT_BABY_ID) || undefined
  }
}

export const actions = {
  getBabies({ commit }) {
    return this.$axios
      .get('babies', {
        params: {
          sort: 'created',
          direction: 'asc'
        }
      })
      .then(function(res) {
        commit('setBabies', { babies: res.data.data })
        return res
      })
  }
}
