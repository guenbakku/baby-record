export const state = () => ({
  headerTitle: undefined
})

export const mutations = {
  setHeaderTitle(state, { value }) {
    state.headerTitle = value
  }
}
