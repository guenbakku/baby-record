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
  data() {
    return {
      typeStyle: {
        backgroundColor: 'royalblue'
      }
    }
  },
  computed: {
    content: function() {
      const content = this.activity.pump_milk_activity
      const seconds = content.duration
      const minutes = this.$moment.duration(seconds, 'seconds').minutes()
      const volume = content.volume
      return `${minutes} phút / ${volume} ml`
    }
  }
}
</script>

<style scoped src="./style.css"></style>
