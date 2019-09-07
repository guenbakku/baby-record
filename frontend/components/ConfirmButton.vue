<template>
  <v-dialog v-model="dialog">
    <template v-slot:activator="{ on }">
      <slot name="activator" :on="on"></slot>
    </template>
    <v-card>
      <v-card-title class="title">Xác nhận</v-card-title>
      <v-divider />
      <v-card-text>{{ message }}</v-card-text>
      <v-divider />
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="info" flat @click="dialog = false">
          Hủy
        </v-btn>
        <v-btn
          color="warning"
          flat
          :loading="loading"
          @click="$emit('confirmed')"
        >
          OK
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  props: {
    message: {
      type: String,
      default: 'Bạn có chắc chắn muốn thực hiện?'
    },
    loading: {
      type: Boolean,
      default: false
    }
  },
  data: () => ({
    dialog: false
  })
}
</script>
