export const state = () => ({
  date: new Date().toISOString().substr(0, 10)
})

export const mutations = {
  setDate(state, { date }) {
    state.date = date
  }
}
