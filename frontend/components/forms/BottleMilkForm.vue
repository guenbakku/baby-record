<template>
  <form>
    <v-text-field
      v-model="form.started"
      label="Bắt đầu"
      required
      type="datetime-local"
    ></v-text-field>
    <v-text-field
      v-model="form.duration"
      label="Thời gian"
      suffix="phút"
      required
      type="number"
    ></v-text-field>
    <v-text-field
      v-model="form.breast_volume"
      label="Lượng sữa mẹ"
      suffix="ml"
    ></v-text-field>
    <v-text-field
      v-model="form.fomular_volume"
      label="Lượng sữa công thức"
      suffix="ml"
    ></v-text-field>
    <v-text-field v-model="form.memo" label="Ghi chú"></v-text-field>
    {{ form.started }}
  </form>
</template>

<script>
export default {
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
  mounted() {
    this.resetForm()
  },
  methods: {
    resetForm() {
      this.$set(
        this.form,
        'started',
        this.$moment().format('YYYY-MM-DD[T]HH:mm')
      )
    }
  }
}
</script>
