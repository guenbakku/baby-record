<template>
  <router-link :to="editRoute" tag="div" class="layout row nowrap activity">
    <div class="time">
      {{ activity.started | moment('HH:mm') }}
    </div>
    <div class="type text-truncate" :style="typeStyle">
      Nhiệt độ
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
import {
  SimpleSubActivity,
  TemperatureSubActivity
} from '~/store/activities/models'

/* eslint-disable camelcase */
type TemperatureActivity = {
  temperature_activity: SimpleSubActivity<TemperatureSubActivity>
}

type Props = {
  activity: ActivityItem<TemperatureActivity>
  color: string
}
/* eslint-enable camelcase */

export default defineComponent({
  props: {
    activity: {
      type: Object as () => Props['activity'],
      default: () =>
        initActivityItem<TemperatureActivity>({
          temperature_activity: {
            temperature: 0
          }
        })
    },
    color: String
  },
  setup(props: Props) {
    const typeStyle = computed(() => getTypeStyle(props.color))
    const editRoute = computed(() => getEditRoute(props.activity.id))
    const content = computed(() => {
      const content = props.activity.temperature_activity
      const temperature = content.temperature
      return `${temperature}°C`
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
