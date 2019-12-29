<template>
  <router-link :to="editRoute" tag="div" class="layout row nowrap activity">
    <div class="time">
      {{ activity.started | moment('HH:mm') }}
    </div>
    <div class="type text-truncate" :style="typeStyle">
      Bú bình
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
import { createComponent, computed, SetupContext } from '@vue/composition-api'
import { ActivityItem, initActivityItem } from './models'
import { getTypeStyle, getEditRoute } from './utils'

/* eslint-disable camelcase */
type BottleMilkActivity = {
  bottle_milk_activity: {
    duration: number
    breast_volume: number
    fomular_volume: number
  }
}

type Props = {
  activity: ActivityItem<BottleMilkActivity>
  color: string
}
/* eslint-enable camelcase */

export default createComponent({
  props: {
    activity: {
      type: Object as () => Props['activity'],
      default: () =>
        initActivityItem<BottleMilkActivity>({
          bottle_milk_activity: {
            duration: 0,
            breast_volume: 0,
            fomular_volume: 0
          }
        })
    },
    color: String
  },
  setup(props: Props, ctx: SetupContext) {
    const typeStyle = computed(() => getTypeStyle(props.color))
    const editRoute = computed(() => getEditRoute(props.activity.id))
    const content = computed(() => {
      const content = props.activity.bottle_milk_activity
      const seconds = content.duration
      const minutes = ctx.root.$store.$moment
        .duration(seconds, 'seconds')
        .asMinutes()
      const breastVolume = content.breast_volume
      const fomularVolume = content.fomular_volume
      const totalVolume = breastVolume + fomularVolume
      return `${minutes} phút / ${totalVolume} ml (SM: ${breastVolume} ml, CT: ${fomularVolume} ml)`
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
