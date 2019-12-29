<template>
  <router-link :to="editRoute" tag="div" class="layout row nowrap activity">
    <div class="time">
      {{ activity.started | moment('HH:mm') }}
    </div>
    <div class="type text-truncate" :style="typeStyle">
      Tự do
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
import { createComponent, computed } from '@vue/composition-api'
import { ActivityItem, initActivityItem } from './models'
import { getTypeStyle, getEditRoute } from './utils'

/* eslint-disable camelcase */
type CustomActivity = {
  custom_activity: {
    title: string
  }
}

type Props = {
  activity: ActivityItem<CustomActivity>
  color: string
}
/* eslint-enable camelcase */

export default createComponent({
  props: {
    activity: {
      type: Object as () => Props['activity'],
      default: () =>
        initActivityItem<CustomActivity>({
          custom_activity: {
            title: ''
          }
        })
    },
    color: String
  },
  setup(props: Props) {
    const typeStyle = computed(() => getTypeStyle(props.color))
    const editRoute = computed(() => getEditRoute(props.activity.id))
    const content = computed(() => props.activity.custom_activity.title)

    return {
      typeStyle,
      editRoute,
      content
    }
  }
})
</script>

<style scoped lang="stylus" src="./style.styl"></style>
