<template>
  <div>
    <v-speed-dial
      v-model="fab"
      bottom
      right
      fixed
      direction="top"
      transition="slide-y-reverse-transition"
    >
      <template v-slot:activator>
        <v-btn v-model="fab" color="success" dark fab>
          <v-icon>add</v-icon>
          <v-icon>close</v-icon>
        </v-btn>
      </template>
      <v-btn
        v-for="item in items"
        :key="item.key"
        :to="item.to"
        color="primary"
        dark
        small
      >
        {{ item.title }}
        <v-icon>add</v-icon>
      </v-btn>
    </v-speed-dial>
  </div>
</template>

<script lang="ts">
import { createComponent, ref } from '@vue/composition-api'
import { Location } from 'vue-router'

export type SpeedDialItem = {
  key: string
  to: Location
  title: string
}

export default createComponent({
  name: 'SpeedDial',
  props: {
    items: {
      type: Array as () => SpeedDialItem[],
      default: () => []
    }
  },
  setup() {
    const fab = ref(false)
    return { fab }
  }
})
</script>

<style lang="stylus">
.v-speed-dial__list {
  align-items: flex-end !important;
  left: auto !important;
  right: -7px !important;
  width: auto !important;

  .v-btn__content {
    margin: 0 5px
  }
}
</style>
