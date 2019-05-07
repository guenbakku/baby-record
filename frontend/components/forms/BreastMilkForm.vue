<template>
  <div>BreastMilkForm {{ form.memo }}</div>
</template>

<script>
export default {
  model: {
    prop: 'reset',
    event: 'reset'
  },
  props: {
    reset: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      form: {
        started: null,
        duration: null,
        breast_volume: null,
        fomular_volume: null,
        memo: null
      }
    }
  },
  watch: {
    reset: {
      immediate: true,
      handler(val) {
        const now = new Date()
        this.$set(this.form, 'started', now.toLocaleString())
        this.$emit('reset', false)
      }
    }
  }
}
</script>
