<template>
  <v-layout row nowrap class="activity">
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
  </v-layout>
</template>

<script>
export default {
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
        backgroundColor: 'crimson'
      }
    }
  },
  computed: {
    content: function() {
      const content = this.activity.bottle_milk_activity
      const seconds = content.duration
      const minutes = this.$moment.duration(seconds, 'seconds').minutes()
      const breastVolume = content.breast_volume
      const fomularVolume = content.fomular_volume
      const totalVolume = breastVolume + fomularVolume
      return `${minutes} phút/${totalVolume} ml (SM: ${breastVolume} ml, CT: ${fomularVolume} ml)`
    }
  }
}
</script>

<style scoped src="./style.css"></style>
