<template>
  <form>
    <v-text-field
      v-model="started_display"
      label="Bắt đầu"
      required
      type="datetime-local"
    ></v-text-field>
    <v-text-field
      v-model.number="duration_display"
      label="Thời gian"
      suffix="phút"
      required
      type="number"
    ></v-text-field>
    <v-text-field
      v-model.number="breast_volume"
      label="Lượng sữa mẹ"
      suffix="ml"
      type="number"
    ></v-text-field>
    <v-text-field
      v-model.number="fomular_volume"
      label="Lượng sữa công thức"
      suffix="ml"
      type="number"
    ></v-text-field>
    <v-text-field v-model="memo" label="Ghi chú"></v-text-field>
  </form>
</template>

<script>
export default {
  data() {
    return {
      started_display: null,
      memo: null,
      duration_display: 0,
      breast_volume: 0,
      fomular_volume: 0
    }
  },
  computed: {
    started: function() {
      return this.$moment(this.started_display)
        .utc()
        .format('YYYY-MM-DD HH:mm:ss')
    },
    duration: function() {
      return this.duration_display * 60
    }
  },
  mounted() {
    this.resetForm()
  },
  methods: {
    resetForm() {
      this.started_display = this.$moment().format('YYYY-MM-DD[T]HH:mm')
    },
    addActivity() {
      const babyId = this.$store.getters['babies/current'].id
      const activity = {
        activity_type_id: 1,
        started: this.started,
        memo: this.memo,
        bottle_milk_activity: {
          duration: this.duration,
          breast_volume: this.breast_volume,
          fomular_volume: this.fomular_volume
        }
      }
      this.$nuxt.$loading.start()
      this.$store
        .dispatch('activities/addActivity', {
          babyId,
          activity
        })
        .then(res => {
          this.$store.commit('flash/success', {
            text: 'Thêm ghi chép thành công'
          })
          this.$nuxt.$loading.finish()
          this.$emit('completed', activity)
        })
    }
  }
}
</script>
