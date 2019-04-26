<template>
  <form>
    <v-text-field
      v-model="form.started"
      label="Bắt đầu"
      required
    ></v-text-field>
    <v-text-field
      v-model="form.duration"
      label="Thời gian"
      mask="##:##:##"
      placeholder="00:00:00"
      required
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
    {{ form.duration }}
  </form>
</template>

<script>
export default {
  data: () => ({
    form: {
      started: null,
      duration: null
    }
  })
}
</script>
