<template>
  <div></div>
</template>

<script lang="ts">
import Vue from 'vue'

export default Vue.extend({
  data() {
    return {
      message: 'test'
    }
  },
  mounted() {
    this.$store.commit('auth/removeToken')
    this.$store.commit('auth/clearAll')
    this.$store.commit('babies/removeCurrentId')
    this.$store.commit('babies/clearAll')
    this.$router.push({ name: 'login' })
  }
})
</script>
