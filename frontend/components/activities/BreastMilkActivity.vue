<template>
  <router-link :to="editRoute" tag="div" class="layout row nowrap activity">
    <div class="time">
      {{ activity.started | moment('HH:mm') }}
    </div>
    <div class="type text-truncate" :style="typeStyle">
      Bú mẹ
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
import {
  SimpleSubActivity,
  BreastMilkSubActivity
} from '~/store/activities/models'

/* eslint-disable camelcase */
type BreastMilkActivity = {
  breast_milk_activity: SimpleSubActivity<BreastMilkSubActivity>
}

type Props = {
  activity: ActivityItem<BreastMilkActivity>
  color: string
}
/* eslint-enable camelcase */

export default defineComponent({
  props: {
    activity: {
      type: Object as () => Props['activity'],
      default: () =>
        initActivityItem<BreastMilkActivity>({
          breast_milk_activity: {
            duration: 0
          }
        })
    },
    color: String
  },
  setup(props: Props, ctx: SetupContext) {
    const typeStyle = computed(() => getTypeStyle(props.color))
    const editRoute = computed(() => getEditRoute(props.activity.id))
    const content = computed(() => {
      const content = props.activity.breast_milk_activity
      const seconds = content.duration
      const minutes = ctx.root.$store.$moment
        .duration(seconds, 'seconds')
        .asMinutes()
      return `${minutes} phút`
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
