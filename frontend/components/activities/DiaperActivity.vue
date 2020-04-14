<template>
  <router-link :to="editRoute" tag="div" class="layout row nowrap activity">
    <div class="time">
      {{ activity.started | moment('HH:mm') }}
    </div>
    <div class="type text-truncate" :style="typeStyle">
      Thay tã
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
type DiaperActivity = {
  diaper_activity: {
    [k: string]: boolean
  }
}

type Props = {
  activity: ActivityItem<DiaperActivity>
  color: string
}
/* eslint-enable camelcase */

export default defineComponent({
  props: {
    activity: {
      type: Object as () => Props['activity'],
      default: () =>
        initActivityItem<DiaperActivity>({
          diaper_activity: {
            is_pee: false,
            is_shit: false
          }
        })
    },
    color: String
  },
  setup(props: Props) {
    const typeStyle = computed(() => getTypeStyle(props.color))
    const editRoute = computed(() => getEditRoute(props.activity.id))
    const content = computed(() => {
      const content = props.activity.diaper_activity
      const events: {
        [k: string]: string
      } = {
        is_pee: 'Tè',
        is_shit: 'Ị'
      }
      for (const key in events) {
        if (!(key in content) || content[key] === false) {
          delete events[key]
        }
      }
      const labels = Object.values(events)
      if (labels.length > 0) {
        return labels.join(' + ')
      } else {
        return 'Không có gì'
      }
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
