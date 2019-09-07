<template>
  <div>
    <v-text-field
      v-model="form.name"
      :error-messages="errors.name"
      label="Tên"
    />
    <v-text-field
      v-model="form.birthday"
      :error-messages="errors.birthday"
      label="Ngày tháng năm sinh"
      required
      type="date"
    />
  </div>
</template>

<script>
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
      default: () => {}
    }
  },
  data() {
    return {
      form: {
        name: null,
        birthday: this.$moment().format('YYYY-MM-DD')
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
          this.form = JSON.parse(JSON.stringify(val))
        }
      }
    }
  },
  methods: {
    getData() {
      return JSON.parse(JSON.stringify(this.form))
    }
  }
}
</script>
