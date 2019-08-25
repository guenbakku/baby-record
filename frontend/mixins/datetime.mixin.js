export default {
  methods: {
    /**
     * Calculate age
     * @param {*} birthday
     * @return {Array} in format [year, month, day]
     */
    calcAge(birthday) {
      const diffTime = this.$moment().diff(birthday)
      const duration = this.$moment.duration(diffTime)
      const age = [duration.years(), duration.months(), duration.days()]

      return age
    }
  }
}
