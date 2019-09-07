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
  /**
   * Get babies list
   * @param {Object} param0
   */
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
  },

  /**
   * Add baby
   * @param {Object} param0
   * @param {Object} param1
   */
  addBaby({ commit }, { baby }) {
    return this.$axios.post('babies', baby)
  },

  /**
   * View baby
   * @param {Object} param0
   * @param {Object} param1
   */
  viewBaby({ commit }, { babyId }) {
    return this.$axios.get(`babies/${babyId}`)
  },

  /**
   * Edit baby
   * @param {Object} param0
   * @param {Object} param1
   */
  editBaby({ commit }, { babyId, baby }) {
    return this.$axios.put(`babies/${babyId}`, baby)
  },

  /**
   * Delete baby
   * @param {Object} param0
   * @param {Object} param1
   */
  deleteBaby({ commit }, { babyId }) {
    return this.$axios.delete(`babies/${babyId}`)
  }
}
