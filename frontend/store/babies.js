const STORAGE_CURRENT_BABY_ID = 'current_baby_id'

export const state = () => ({
  current: undefined,
  babies: {
    "32457bf2-7f72-4416-98f5-aed93363aa02": {
      id: "32457bf2-7f72-4416-98f5-aed93363aa02",
      name: "Yuna",
      birthday: "2019-03-31",
      avatar: "https://vuetifyjs.com/apple-touch-icon-180x180.png"
    },
    "b5dfe1ce-22ac-4f80-a611-9befe4fc3692": {
      id: "b5dfe1ce-22ac-4f80-a611-9befe4fc3692",
      name: "Rina",
      birthday: "2019-03-31",
      avatar: "https://vuetifyjs.com/apple-touch-icon-180x180.png"
    }
  }
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
  }
}
