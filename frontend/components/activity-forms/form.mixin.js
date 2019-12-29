/**
 * Containing source code which is shared between all forms.
 */
export default {
  props: {
    data: {
      type: Object,
      default() {
        return {}
      }
    },
    errors: {
      type: Object,
      default() {
        return {}
      }
    }
  },
  computed: {
    isPropDataSet() {
      return this.$options.propsData.data !== undefined
    }
  },
  watch: {
    data: {
      immediate: true,
      handler(val) {
        if (this.isPropDataSet) {
          let form
          if (this.transformPropToData) {
            form = this.transformPropToData(val)
          } else {
            form = JSON.parse(JSON.stringify(val))
          }
          this.form = form
        }
      }
    }
  },
  methods: {
    /**
     * Abtract methods:
     *
     * transformPropToData()
     * transformDataToProp()
     */

    // -----
    getData() {
      if (this.transformDataToProp) {
        return this.transformDataToProp(this.form)
      } else {
        return JSON.parse(JSON.stringify(this.form))
      }
    }
  }
}
