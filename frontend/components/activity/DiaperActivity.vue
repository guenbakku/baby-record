<template>
  <v-layout row nowrap class="activity">
    <div class="time">
      {{ activity.started | moment('HH:mm') }}
    </div>
    <div class="type text-truncate" :style="typeStyle">
      Tã
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
        backgroundColor: 'blueviolet'
      }
    }
  },
  computed: {
    content: function() {
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

<style scoped src="./style.css"></style>
