export const state = () => ({
  headerTitle: undefined,
  useBabySwitch: false
})

export const mutations = {
  setHeaderTitle(state, { value }) {
    state.headerTitle = value
  },
  setUseBabySwitch(state, { value }) {
    state.useBabySwitch = value
  }
}
