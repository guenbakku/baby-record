<template>
  <div></div>
</template>

<script>
export default {
  mounted() {
    this.$store.commit('auth/removeToken')
    this.$store.commit('auth/clearAll')
    this.$store.commit('babies/removeCurrentId')
    this.$store.commit('babies/clearAll')
    this.$router.push({ name: 'login' })
  }
}
</script>
