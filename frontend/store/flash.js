const COLORS = {
  error: 'error',
  success: 'success'
}

export const state = () => ({
  text: undefined,
  type: undefined,
  show: false
})

export const getters = {
  color(state) {
    return COLORS[state.type]
  }
}

export const mutations = {
  error(state, { text }) {
    state.text = text
    state.type = 'error'
    state.show = true
  },
  success(state, { text }) {
    state.text = text
    state.type = 'success'
    state.show = true
  },
  hide(state) {
    state.show = false
  }
}
