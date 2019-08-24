<template>
  <component :is="component" :activity="activity" :color="color" />
</template>

<script>
import { loadComponents, getMaps } from './maps'

export default {
  components: {
    ...loadComponents()
  },
  props: {
    activity: {
      type: Object,
      default: () => ({})
    }
  },
  computed: {
    component: function() {
      return getMaps()[this.activity.activity_type.code].component
    },
    color: function() {
      return getMaps()[this.activity.activity_type.code].color
    }
  }
}
</script>
