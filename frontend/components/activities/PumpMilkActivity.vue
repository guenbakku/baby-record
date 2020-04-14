<template>
  <router-link :to="editRoute" tag="div" class="layout row nowrap activity">
    <div class="time">
      {{ activity.started | moment('HH:mm') }}
    </div>
    <div class="type text-truncate" :style="typeStyle">
      Vắt sữa
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
import { defineComponent, computed, SetupContext } from '@vue/composition-api'
import { ActivityItem, initActivityItem } from './models'
import { getTypeStyle, getEditRoute } from './utils'

/* eslint-disable camelcase */
type PumpMilkActivity = {
  pump_milk_activity: {
    duration: number
    volume: number
  }
}

type Props = {
  activity: ActivityItem<PumpMilkActivity>
  color: string
}
/* eslint-enable camelcase */

export default defineComponent({
  props: {
    activity: {
      type: Object as () => Props['activity'],
      default: () =>
        initActivityItem<PumpMilkActivity>({
          pump_milk_activity: {
            duration: 0,
            volume: 0
          }
        })
    },
    color: String
  },
  setup(props: Props, ctx: SetupContext) {
    const typeStyle = computed(() => getTypeStyle(props.color))
    const editRoute = computed(() => getEditRoute(props.activity.id))
    const content = computed(() => {
      const content = props.activity.pump_milk_activity
      const seconds = content.duration
      const minutes = ctx.root.$store.$moment
        .duration(seconds, 'seconds')
        .asMinutes()
      const volume = content.volume
      return `${minutes} phút / ${volume} ml`
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
