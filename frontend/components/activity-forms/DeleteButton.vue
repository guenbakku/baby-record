<template>
  <v-dialog v-model="dialog">
    <template v-slot:activator="{ on }">
      <v-btn color="error" v-on="on">Xóa</v-btn>
    </template>
    <v-card>
      <v-card-title class="title">Xác nhận</v-card-title>
      <v-divider />
      <v-card-text>Bạn có chắc chắn muốn xóa ghi chép này?</v-card-text>
      <v-divider />
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="info" flat @click="dialog = false">Hủy</v-btn>
        <v-btn color="warning" flat :loading="loading" @click="deleteActivity">
          OK
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  props: {
    activityId: {
      type: String,
      default: undefined
    }
  },
  data: () => ({
    dialog: false,
    loading: false
  }),
  methods: {
    deleteActivity: function() {
      this.loading = true
      this.$store
        .dispatch('activities/deleteActivity', { activityId: this.activityId })
        .then(res => {
          this.$store.commit('flash/success', {
            text: 'Xóa ghi chép thành công'
          })
          this.$emit('deleted', this.activityId)
        })
        .catch(err => {
          if (err.response && err.response.status === 404) {
            this.$store.commit('flash/error', {
              text: 'Không tìm thấy ghi chép'
            })
          }
        })
        .then(() => {
          this.loading = false
        })
    }
  }
}
</script>
