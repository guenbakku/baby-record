<template>
  <v-list class="pt-0 pb-0">
    <baby-item v-for="(baby, id) in babies" :key="id" :baby="baby" />
  </v-list>
</template>

<script>
import BabyItem from '~/components/babies/BabyItem'

export default {
  components: { BabyItem },
  props: {
    babies: {
      type: Object,
      default: () => {}
    }
  }
}
</script>
