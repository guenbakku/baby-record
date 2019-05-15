/**
 * Containing source code which is shared between all forms.
 */
export default {
  props: {
    data: {
      type: Object,
      default: function() {
        return {}
      }
    },
    errors: {
      type: Object,
      default: function() {
        return {}
      }
    }
  },
  computed: {
    isPropDataSet: function() {
      return this.$options.propsData.data !== undefined
    }
  },
  watch: {
    data: {
      immediate: true,
      handler: function(val) {
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
