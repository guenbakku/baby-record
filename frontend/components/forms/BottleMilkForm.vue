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
    <v-text-field
      v-model="form.memo"
      label="Ghi chú"
    ></v-text-field>
    {{ test }}
    {{ form.memo }}
  </form>
</template>

<script>
export default {
  props: {
    test: {
      type: Number,
      default: null
    }
  },
  data() {
    return {
      form: {
        started: null,
        duration: null,
        breast_volume: null,
        fomular_volume: null,
        memo: this.test
      }
    }
  },
}
</script>
