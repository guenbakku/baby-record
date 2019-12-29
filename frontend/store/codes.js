export const actions = {
  /**
   * Get provided codes from server
   * @param {Object} param0
   * @param {Object} param1
   */
  viewCode(_, { model }) {
    return this.$axios.get(`/codes/${model}`, { useCache: true }).then(res => {
      // Translate codes
      res.data.data.codes = res.data.data.codes.map(item => {
        item.text = this.$i18n.t(item.text)
        return item
      })

      return res
    })
  }
}
