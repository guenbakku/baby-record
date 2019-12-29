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

<script>
import ActivityMixin from './activity.mixin'

export default {
  mixins: [ActivityMixin],
  props: {
    activity: {
      type: Object,
      default: () => ({
        id: undefined,
        started: undefined,
        memo: undefined,
        activity_type: {
          code: undefined,
          label: undefined
        }
      })
    }
  },
  computed: {
    content() {
      const content = this.activity.diaper_activity
      const events = {
        is_pee: 'Tè',
        is_shit: 'Ị'
      }
      for (const key in events) {
        if (!content[key]) {
          delete events[key]
        }
      }
      const labels = Object.values(events)
      if (labels.length > 0) {
        return labels.join(' + ')
      } else {
        return 'Không có gì'
      }
    }
  }
}
</script>

<style scoped lang="stylus" src="./style.styl"></style>
