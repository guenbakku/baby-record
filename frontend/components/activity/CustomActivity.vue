<template>
  <v-layout row nowrap class="activity">
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
        backgroundColor: 'deeppink'
      }
    }
  },
  computed: {
    content: function() {
      const content = this.activity.custom_activity
      return content.title
    }
  }
}
</script>

<style scoped src="./style.css"></style>
