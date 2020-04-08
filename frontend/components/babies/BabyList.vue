<template>
  <v-list class="pt-0 pb-0">
    <baby-item v-for="(baby, id) in babies" :key="id" :baby="baby" />
  </v-list>
</template>

<script lang="ts">
import { createComponent } from '@vue/composition-api'
import { Baby, initBaby } from './models'
import BabyItem from '~/components/babies/BabyItem.vue'

type Props = {
  babies: {
    [k: string]: Baby
  }
}

export default createComponent({
  components: { BabyItem },
  props: {
    babies: {
      type: Object as () => Props['babies'],
      default: () => ({
        dummy: initBaby()
      })
    }
  }
})
</script>
