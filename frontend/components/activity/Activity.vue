<template>
  <v-layout row nowrap class="activity">
    <div class="time">
      10:00
    </div>
    <div class="type" :style="typeStyle">
      Bú bình
    </div>
    <div class="content">
      500 ml (SM: 100 ml, CT: 400ml)
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
  computed: {
    activityType: function() {
      return this.activity.activity_type.code
    },
    typeStyle: function() {
      const styles = {
        breast_milk_activity: {
          backgroundColor: 'orange'
        },
        bottle_milk_activity: {
          backgroundColor: 'crimson'
        }
      }
      return styles[this.activityType]
    }
  }
}
</script>

<style scoped>
.activity {
  padding: 15px 10px;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
}
.activity:first-child {
  border-top: none;
}
.time {
  display: flex;
  width: 45px;
  min-width: 45px;
}
.type {
  display: flex;
  width: 60px;
  min-width: 60px;
  align-items: center;
  justify-content: center;
}
.content {
  display: flex;
  padding-left: 5px;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}
</style>
