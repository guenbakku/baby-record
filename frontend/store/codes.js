export const actions = {
  /**
   * Get provided codes from server
   * @param {Object} param0
   * @param {Object} param1
   */
  viewCode({ commit }, { model }) {
    return this.$axios.get(`/codes/${model}`).then(res => res)
  }
}
