<template>
  <v-layout row wrap class="pd-5">
    <v-flex xs12>
      <v-card>
        <loading v-if="!completed" />
        <no-data v-else-if="isNoData" />
        <!-- Dummy -->
        <activity
          v-for="activity in activities"
          v-else
          :key="activity.id"
          :activity="activity"
        />
      </v-card>
    </v-flex>
    <v-btn fixed dark fab bottom right color="success" :to="addRoute">
      <v-icon>add</v-icon>
    </v-btn>
  </v-layout>
</template>

<script lang="ts">
import { defineComponent, ref, computed, watch } from '@vue/composition-api'
import { useStore } from '@u3u/vue-hooks'
import { Location } from 'vue-router'
import Activity from '~/components/activities/Activity.vue'
import Loading from '~/components/core/card-text/Loading.vue'
import NoData from '~/components/core/card-text/NoData.vue'
import { RootState } from '~/store/models'

export default defineComponent({
  useBabySwitch: true,
  components: { Activity, Loading, NoData },
  setup() {
    const store = useStore<RootState>()

    const completed = ref<boolean>(false)
    const isNoData = computed(() => {
      return completed.value && Object.keys(activities.value || {}).length === 0
    })
    const baby = computed(() => store.value.getters['babies/current'])
    const activities = computed(() => {
      return store.value.state.measurements.activities
    })

    const addRoute = computed(
      (): Location => ({
        name: 'activities-add-type',
        params: { type: 'measurement_activity' }
      })
    )

    const getMeasurementActivities = () => {
      completed.value = false
      store.value
        .dispatch('measurements/getActivities', {
          babyId: baby.value.id
        })
        .finally(() => {
          completed.value = true
        })
    }

    watch([baby], (vals: any) => {
      const shouldCall = vals.filter((val: any) => !!val).length === vals.length
      if (shouldCall) {
        getMeasurementActivities()
      }
    })

    return {
      completed,
      activities,
      addRoute,
      isNoData
    }
  }
})
</script>
