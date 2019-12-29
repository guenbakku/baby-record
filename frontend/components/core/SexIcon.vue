<template>
  <v-icon :large="large" :color="color">{{ icon }}</v-icon>
</template>

<script lang="ts">
import { createComponent, computed } from '@vue/composition-api'
import { SexId } from '~/store/babies/models'

type Maps = {
  [k: number]: string
}

type Props = {
  sexId: SexId | null
  large: boolean
  color: string
}

const MAPS: Maps = {
  1: 'icon-boy',
  2: 'icon-girl'
}

export default createComponent({
  props: {
    sexId: {
      type: Number as () => SexId,
      default: null
    },
    large: {
      type: Boolean,
      default: false
    },
    color: {
      type: String,
      default: null
    }
  },
  setup(props: Props) {
    const icon = computed(() =>
      props.sexId !== null ? MAPS[props.sexId] || null : null
    )
    return { icon }
  }
})
</script>
