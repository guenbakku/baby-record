<i18n>
{
  "vi": {
    "Bottle Milk": "Bú bình",
    "Breast Milk": "Bú mẹ",
    "Pump Milk": "Vắt sữa",
    "Diaper": "Tã"
  }
}
</i18n>

<template>
  <v-layout row nowrap class="activity">
    <div class="time">
      {{ activity.started | moment('HH:mm') }}
    </div>
    <div class="type text-truncate" :style="typeStyle">
      {{ $t(activity.activity_type.label) }}
    </div>
    <div class="content">
      <span>500 ml (SM: 100 ml, CT: 400ml)</span>
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
  computed: {
    activityType: function() {
      window.console.log(this.$i18n.locale)
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
  align-items: center;
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
  align-items: center;
  flex-wrap: wrap;
}
</style>
