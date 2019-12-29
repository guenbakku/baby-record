<template>
  <div></div>
</template>

<script lang="ts">
import { createComponent, SetupContext, onMounted } from '@vue/composition-api'

export default createComponent({
  setup(_, ctx: SetupContext) {
    onMounted(() => {
      ctx.root.$store.commit('auth/removeToken')
      ctx.root.$store.commit('auth/clearAll')
      ctx.root.$store.commit('babies/removeCurrentId')
      ctx.root.$store.commit('babies/clearAll')
      ctx.root.$router.push({ name: 'login' })
    })
  }
})
</script>
