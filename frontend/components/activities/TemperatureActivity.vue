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
      const content = this.activity.temperature_activity
      const temperature = content.temperature
      return `${temperature}°C`
    }
  }
}
</script>

<style scoped lang="stylus" src="./style.styl"></style>
