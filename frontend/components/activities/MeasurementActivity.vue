<template>
  <router-link :to="editRoute" tag="div" class="layout row nowrap activity">
    <div class="time">
      {{ activity.started | moment('HH:mm') }}
    </div>
    <div class="type" :style="typeStyle">
      Số đo
    </div>
    <div class="content">
      <span>{{ content }}</span>
      <span class="grey--text">{{ activity.memo }}</span>
    </div>
    <v-spacer />
    <v-icon>keyboard_arrow_right</v-icon>
  </router-link>
</template>

<script lang="ts">
import { defineComponent, computed } from '@vue/composition-api'
import { ActivityItem, initActivityItem } from './models'
import { getTypeStyle, getEditRoute } from './utils'

/* eslint-disable camelcase */
type MeasurementActivity = {
  measurement_activity: {
    height?: number
    weight?: number
  }
}

type Props = {
  activity: ActivityItem<MeasurementActivity>
  color: string
}
/* eslint-enable camelcase */

export default defineComponent({
  props: {
    activity: {
      type: Object as () => Props['activity'],
      default: () =>
        initActivityItem<MeasurementActivity>({
          measurement_activity: {
            height: undefined,
            weight: undefined
          }
        })
    },
    color: String
  },
  setup(props: Props) {
    const typeStyle = computed(() => getTypeStyle(props.color))
    const editRoute = computed(() => getEditRoute(props.activity.id))
    const content = computed(() => {
      const content = props.activity.measurement_activity
      const height = content.height || '-'
      const weight = content.weight || '-'
      return `${height} cm / ${weight} kg`
    })

    return {
      typeStyle,
      editRoute,
      content
    }
  }
})
</script>

<style scoped lang="stylus" src="./style.styl"></style>
