<template>
  <component :is="component" :activity="activity" :color="color" />
</template>

<script lang="ts">
import { defineComponent, computed } from '@vue/composition-api'
import { loadComponents, getMaps } from './maps'
import { ActivityItem } from './models'

type Props = {
  activity: ActivityItem<object>
}

export default defineComponent({
  components: {
    ...loadComponents()
  },
  props: {
    activity: {
      type: Object as () => Props['activity'],
      default: () => ({})
    }
  },
  setup(props: Props) {
    const component = computed(
      () => getMaps()[props.activity.activity_type.code].component
    )
    const color = computed(
      () => getMaps()[props.activity.activity_type.code].color
    )

    return {
      component,
      color
    }
  }
})
</script>
