<template>
  <v-snackbar v-model="snackbar" :color="color" :timeout="timeout" top>
    {{ text }}
    <v-btn dark flat @click="snackbar = false">
      <v-icon>close</v-icon>
    </v-btn>
  </v-snackbar>
</template>

<script>
export default {
  data: () => ({
    timeout: 6000
  }),
  computed: {
    snackbar: {
      get() {
        return this.$store.state.flash.show
      },
      set(_) {
        this.$store.commit('flash/hide')
      }
    },
    text() {
      return this.$store.state.flash.text
    },
    color() {
      return this.$store.getters['flash/color']
    }
  }
}
</script>
