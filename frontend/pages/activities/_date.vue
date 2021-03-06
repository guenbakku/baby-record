<template>
  <v-layout row wrap class="pb-5">
    <v-flex xs12>
      <v-card class="table">
        <v-card-actions style="justify-content: center; min-height: 52px">
          <date-picker :date="date" @selected="changeDate" />
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
            {{ summaryResult.bottle_milk_activity.total_volume }} ml
            <br />
            (SM: {{ summaryResult.bottle_milk_activity.breast_volume }} ml,
            CT: {{ summaryResult.bottle_milk_activity.fomular_volume }} ml)
            <!--eslint-enable-->
          </v-flex>
        </v-layout>
        <v-layout row nowrap>
          <v-flex xs6 class="cell">
            <span class="header">Thay tã</span>
            <!-- eslint-disable prettier/prettier -->
            {{ summaryResult.diaper_activity.times }} lần
            (tè: {{ summaryResult.diaper_activity.pee_times }} lần,
            ị: {{ summaryResult.diaper_activity.shit_times }} lần)
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
    <v-flex xs12 class="mt-2">
      <v-card>
        <loading v-if="!completed" />
        <no-data v-else-if="isNoData" />
        <activity v-for="activity in activities" v-else :key="activity.id" :activity="activity" />
      </v-card>
    </v-flex>
    <speed-dial :items="speedDialItems"/>
  </v-layout>
</template>

<script lang="ts">
import {
  defineComponent,
  ref,
  computed,
  watch,
  onMounted,
  SetupContext
} from '@vue/composition-api'
import Axios from 'axios'
import { Context } from '@nuxt/types/app'
import { useStore } from '@u3u/vue-hooks'
import Activity from '~/components/activities/Activity.vue'
import DatePicker from '~/components/activities/DatePicker.vue'
import Loading from '~/components/core/card-text/Loading.vue'
import NoData from '~/components/core/card-text/NoData.vue'
import SpeedDial from '~/components/core/SpeedDial.vue'
import { getMaps } from '~/components/activity-forms/maps'
import { RootState } from '~/store/models'

export default defineComponent({
  useBabySwitch: true,
  components: {
    Activity,
    DatePicker,
    Loading,
    NoData,
    SpeedDial
  },
  validate({ params }: Context) {
    return !params.date || /^\d{4}-\d{2}-\d{2}$/.test(params.date)
  },
  setup(_, ctx: SetupContext) {
    const store = useStore<RootState>()

    const completed = ref<boolean>(false)
    const summaryResult = ref<any>({
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
    })

    const activities = computed(() => store.value.state.activities.activities)
    const baby = computed(() => store.value.getters['babies/current'])
    const date = computed<string>(
      () =>
        ctx.root.$route.params.date ||
        store.value.state.activities.date ||
        ctx.root.$moment().format('YYYY-MM-DD')
    )
    const isNoData = computed(
      () => completed.value && activities.value.length === 0
    )
    const speedDialItems = computed(() => {
      const map = getMaps()
      const items = []
      for (const key in map) {
        const item = {
          key,
          title: map[key].title,
          to: {
            name: 'activities-add-type',
            params: { type: key }
          }
        }
        items.push(item)
      }
      return items
    })

    const changeDate = (date: string) => {
      ctx.root.$router.push({ name: 'activities-date', params: { date } })
    }

    const summary = () => {
      const methods: {
        [k: string]: any
      } = {
        breast_milk_activity: {
          result: {
            times: 0,
            duration: 0
          },
          invoke(subActivity: any) {
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
          invoke(subActivity: any) {
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
          invoke(subActivity: any) {
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
          invoke(subActivity: any) {
            this.result.times++
            this.result.volume += subActivity.volume
          }
        }
      }

      // Summary depending on methods
      for (const activity of activities.value) {
        const type = activity.activity_type.code
        if (methods[type]) {
          methods[type].invoke((activity as any)[type])
        }
      }

      // Set summarized result
      for (const type in methods) {
        ;(summaryResult.value as any)[type] = methods[type].result
      }
    }

    const getActivities = () => {
      const cancelTokenSource =
        store.value.state.activities.cancelTokenSources.getActivities

      if (cancelTokenSource) {
        cancelTokenSource.cancel()
      }

      completed.value = false
      store.value
        .dispatch('activities/getActivities', {
          babyId: baby.value.id,
          date: date.value
        })
        .then(_ => {
          summary()
        })
        .catch(function(err) {
          if (!Axios.isCancel(err)) {
            window.console.log(err)
          }
        })
        .finally(() => {
          completed.value = true
        })
    }

    watch([baby, date], vals => {
      const shouldCall = vals.filter(val => !!val).length === vals.length
      if (shouldCall) {
        getActivities()
      }
    })

    onMounted(() => {
      store.value.commit('activities/setActivities', { activities: {} })
      store.value.commit('activities/setDate', { date: date.value })
    })

    return {
      completed,
      summaryResult,
      activities,
      baby,
      date,
      isNoData,
      speedDialItems,
      changeDate,
      getActivities
    }
  }
})
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
