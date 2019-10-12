<template>
  <v-icon :large="large" :color="color">{{ icon }}</v-icon>
</template>

<script>
const MAPS = {
  1: 'icon-boy',
  2: 'icon-girl'
}

export default {
  props: {
    sexId: {
      type: Number,
      default: undefined
    },
    large: {
      type: Boolean,
      default: false
    },
    color: {
      type: String,
      default: undefined
    }
  },
  computed: {
    icon() {
      return MAPS[this.sexId] || undefined
    }
  }
}
</script>
