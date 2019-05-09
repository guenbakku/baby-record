<i18n>
{
  "vi": {
    "Bottle Milk": "Bú bình",
    "Breast Milk": "Bú mẹ",
    "Pump Milk": "Vắt sữa",
    "Diaper": "Tã",
    "Temperature": "Nhiệt độ",
    "Custom": "Tự do"
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
  computed: {
    typeStyle: function() {
      const styles = {
        breast_milk_activity: {
          backgroundColor: 'teal'
        },
        bottle_milk_activity: {
          backgroundColor: 'crimson'
        },
        diaper_activity: {
          backgroundColor: 'blueviolet'
        },
        temperature_activity: {
          backgroundColor: 'firebrick'
        },
        pump_milk_activity: {
          backgroundColor: 'royalblue'
        },
        custom_activity: {
          backgroundColor: 'deeppink'
        }
      }
      return styles[this.activity.activity_type.code]
    },
    content: function() {
      switch (this.activity.activity_type.code) {
        case 'temperature_activity': {
          const temperature = this.activity.temperature_activity.temperature
          return `${temperature}°C`
        }
        case 'pump_milk_activity': {
          const seconds = this.activity.pump_milk_activity.duration
          const minutes = Math.floor(
            this.$moment.duration(seconds, 'seconds').asMinutes()
          )
          const volume = this.activity.pump_milk_activity.volume
          return `${minutes} phút/${volume} ml`
        }
        case 'diaper_activity': {
          const events = {
            is_pee: 'Tè',
            is_shit: 'Ị'
          }
          for (const key in events) {
            if (!this.activity.diaper_activity[key]) {
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
        case 'breast_milk_activity': {
          const seconds = this.activity.breast_milk_activity.duration
          const minutes = Math.floor(
            this.$moment.duration(seconds, 'seconds').asMinutes()
          )
          return `${minutes} phút`
        }
        case 'bottle_milk_activity': {
          const seconds = this.activity.bottle_milk_activity.duration
          const minutes = Math.floor(
            this.$moment.duration(seconds, 'seconds').asMinutes()
          )
          const breastVolume = this.activity.bottle_milk_activity.breast_volume
          const fomularVolume = this.activity.bottle_milk_activity
            .fomular_volume
          const totalVolume = breastVolume + fomularVolume
          return `${minutes} phút/${totalVolume} ml (SM: ${breastVolume} ml, CT: ${fomularVolume} ml)`
        }
        case 'custom_activity': {
          return this.activity.custom_activity.title
        }
        default:
          return 'Unknown'
      }
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
