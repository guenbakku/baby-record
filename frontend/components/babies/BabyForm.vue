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
    <v-select
      v-model="form.sex_id"
      :items="sexes"
      :loading="isInitializing"
      :error-messages="errors.sex_id"
      label="Giới tính"
    ></v-select>
  </div>
</template>

<script>
import InitializationStatusMixin from '~/mixins/initialization-status.mixin'

export default {
  mixins: [InitializationStatusMixin],
  props: {
    data: {
      type: Object,
      default: () => {}
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
        birthday: this.$moment().format('YYYY-MM-DD'),
        sex_id: null
      },
      sexes: []
    }
  },
  watch: {
    data: {
      immediate: true,
      handler(val) {
        if (Object.keys(val || {}).length > 0) {
          this.form = JSON.parse(JSON.stringify(val))
        }
      }
    }
  },
  mounted() {
    this.setInitializing()
    Promise.all([this.getSexCodes()])
      .then(_ => {
        this.setInitializationSuccess()
        this.$emit('initialized')
      })
      // eslint-disable-next-line handle-callback-err
      .catch(_ => {
        this.setInitializationError()
      })
  },
  methods: {
    getData() {
      return JSON.parse(JSON.stringify(this.form))
    },
    getSexCodes() {
      return this.$store
        .dispatch('codes/viewCode', { model: 'sexes' })
        .then(res => {
          this.sexes = res.data.data.codes
          return res
        })
        .catch(err => {
          throw err
        })
    }
  }
}
</script>
