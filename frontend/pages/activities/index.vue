<template>
  <v-layout row wrap>
    <v-flex xs12>
      <v-card class="table">
        <v-card-actions style="justify-content: center">
          <date-picker />
        </v-card-actions>
        <v-layout row nowrap>
          <v-flex xs6 class="cell">
            <span class="header">Bú mẹ</span>
            <!-- eslint-disable prettier/prettier -->
            {{ summaryResult.breast_milk_activity.times }} lần /
            {{ { seconds: summaryResult.breast_milk_activity.duration } | duration('minutes') }} phút
            <!--eslint-enable-->
          </v-flex>
          <v-flex xs6 class="cell">
            <span class="header">Bú bình</span>
            <!-- eslint-disable prettier/prettier -->
            {{ summaryResult.bottle_milk_activity.times }} lần /
            {{ summaryResult.bottle_milk_activity.total_volume }} ml <br />
            (SM: {{ summaryResult.bottle_milk_activity.breast_volume }} ml,
              CT: {{ summaryResult.bottle_milk_activity.fomular_volume }} ml)
            <!--eslint-enable-->
          </v-flex>
        </v-layout>
        <v-layout row nowrap>
          <v-flex xs6 class="cell">
            <span class="header">Tã</span>
            <!-- eslint-disable prettier/prettier -->
            {{ summaryResult.diaper_activity.times }} lần
            (ị: {{ summaryResult.diaper_activity.shit_times }} lần,
              tè: {{ summaryResult.diaper_activity.pee_times }} lần)
            <!-- eslint-enable -->
          </v-flex>
          <v-flex xs6 class="cell">
            <span class="header">Vắt sữa</span>
            <!-- eslint-disable prettier/prettier -->
            {{ summaryResult.pump_milk_activity.times }} lần /
            {{ summaryResult.pump_milk_activity.volume }} ml
            <!-- eslint-enable -->
          </v-flex>
        </v-layout>
      </v-card>
    </v-flex>
    <v-flex xs12 class="mt-3">
      <v-card>
        <v-card-text v-if="isNoData">
          <v-icon>room_service</v-icon>
          Không có dữ liệu
        </v-card-text>
        <activity
          v-for="activity in activities"
          :key="activity.id"
          :activity="activity"
        />
      </v-card>
    </v-flex>
    <speed-dial />
  </v-layout>
</template>

<script>
import Activity from '~/components/activity/Activity'
import DatePicker from '~/components/activity/DatePicker'
import SpeedDial from '~/components/SpeedDial'

export default {
  components: {
    Activity,
    DatePicker,
    SpeedDial
  },
  data() {
    return {
      completed: false,
      summaryResult: {
        breast_milk_activity: {
          times: 0,
          duration: 0
        },
        bottle_milk_activity: {
          times: 0,
          breast_volume: 0,
          fomular_volume: 0,
          total_volume: 0
        },
        diaper_activity: {
          times: 0,
          pee_times: 0,
          shit_times: 0
        },
        pump_milk_activity: {
          times: 0,
          volume: 0
        }
      }
    }
  },
  computed: {
    activities: function() {
      return this.$store.state.activities.activities
    },
    baby: function() {
      return this.$store.getters['babies/getCurrent']
    },
    date: function() {
      return this.$store.state.activities.date
    },
    babyAndDate: function() {
      return [this.baby, this.date]
    },
    isNoData: function() {
      return this.completed && this.activities.length === 0
    }
  },
  watch: {
    babyAndDate: function(vals) {
      this.$store.commit('activities/setActivities', { activities: {} })
      const shouldCall = vals.filter(vals => !!vals).length > 0
      if (shouldCall) {
        this.completed = false
        this.$nuxt.$loading.start()
        this.$store
          .dispatch('activities/getActivities', {
            babyId: this.baby.id,
            date: this.date
          })
          .then(res => {
            this.summary()
            this.completed = true
            this.$nuxt.$loading.finish()
          })
      }
    }
  },
  methods: {
    summary: function() {
      const methods = {
        breast_milk_activity: {
          result: {
            times: 0,
            duration: 0
          },
          invoke: function(subActivity) {
            this.result.times++
            this.result.duration += subActivity.duration
          }
        },
        bottle_milk_activity: {
          result: {
            times: 0,
            breast_volume: 0,
            fomular_volume: 0,
            total_volume: 0
          },
          invoke: function(subActivity) {
            this.result.times++
            this.result.breast_volume += subActivity.breast_volume
            this.result.fomular_volume += subActivity.fomular_volume
            this.result.total_volume =
              this.result.breast_volume + this.result.fomular_volume
          }
        },
        diaper_activity: {
          result: {
            times: 0,
            pee_times: 0,
            shit_times: 0
          },
          invoke: function(subActivity) {
            this.result.times++
            if (subActivity.is_pee) {
              this.result.pee_times++
            }
            if (subActivity.is_shit) {
              this.result.shit_times++
            }
          }
        },
        pump_milk_activity: {
          result: {
            times: 0,
            volume: 0
          },
          invoke: function(subActivity) {
            this.result.times++
            this.result.volume += subActivity.volume
          }
        }
      }

      // Summary depending on methods
      for (const activity of this.activities) {
        const type = activity.activity_type.code
        if (methods[type]) {
          methods[type].invoke(activity[type])
        }
      }

      // Set summarized result
      for (const type in methods) {
        this.$set(this.summaryResult, type, methods[type].result)
      }
    }
  }
}
</script>

<style>
.table .row {
  border-top: 1px solid rgba(255, 255, 255, 0.1);
}
.table .row:first-child {
  border-top: none;
}
.table .cell {
  border-left: 1px solid rgba(255, 255, 255, 0.1);
  padding: 4px;
}
.table .cell:first-child {
  border-left: none;
}
.table .header {
  display: block;
  color: rgba(255, 255, 255, 0.7);
  font-weight: bold;
}
</style>
