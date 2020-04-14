<template>
  <v-layout row nowrap>
    <v-flex xs12>
      <v-card>
        <v-form @submit.prevent="editActivity">
          <v-card-actions>
            <v-btn :to="getRouteToActivitiesPage()" icon active-class="dummy">
              <v-icon>keyboard_backspace</v-icon>
            </v-btn>
            <span class="subheading">Sửa {{ title.toLowerCase() }}</span>
          </v-card-actions>
          <v-divider />
          <v-card-text>
            <component
              :is="component"
              v-if="activity"
              ref="formRef"
              :data="activity"
              :errors="errors"
            />
            <v-progress-circular v-else indeterminate color="success" />
          </v-card-text>
          <v-divider />
          <v-card-actions v-if="activity">
            <v-btn :loading="loading" type="submit" color="success">
              Sửa
            </v-btn>
            <v-spacer />
            <confirm-dialog :loading="loading" @confirmed="deleteActivity()">
              <template v-slot:activator="{ on }">
                <v-btn :loading="loading" color="error" v-on="on">Xóa</v-btn>
              </template>
              <template v-slot:message>
                Bạn có chắc chắn muốn xóa ghi chép này?
              </template>
            </confirm-dialog>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-flex>
  </v-layout>
</template>

<script lang="ts">
import {
  defineComponent,
  ref,
  computed,
  onMounted,
  SetupContext
} from '@vue/composition-api'
import { useStore } from '@u3u/vue-hooks'
import { Location } from 'vue-router'
import { RootState } from '~/store/models'
import { loadComponents, getMaps } from '~/components/activity-forms/maps'
import ConfirmDialog from '~/components/core/ConfirmDialog.vue'
import { ActivityItem } from '~/components/activities/models'

export default defineComponent({
  useBabySwitch: true,
  components: {
    ...loadComponents(),
    ConfirmDialog
  },
  setup(_, ctx: SetupContext) {
    const store = useStore<RootState>()

    const formRef = ref<any>(null)
    const activity = ref<ActivityItem>()
    const errors = ref<any>()
    const loading = ref<boolean>(false)

    const date = computed(() => store.value.state.activities.date)
    const type = computed<string | undefined>(() =>
      activity.value ? activity.value.activity_type.code : undefined
    )
    const component = computed(() =>
      type.value ? getMaps()[type.value].component : undefined
    )
    const title = computed(() =>
      type.value ? getMaps()[type.value].title : ''
    )
    const activityId = computed(() => ctx.root.$route.params.id)

    const getRouteToActivitiesPage = (inputDate?: string): Location => {
      const paramDate = inputDate || date.value || ''
      return { name: 'activities-date', params: { date: paramDate } }
    }

    const getActivity = () => {
      store.value
        .dispatch('activities/viewActivity', { activityId: activityId.value })
        .then(res => {
          activity.value = res.data.data
        })
        .catch(err => {
          if (err.response && err.response.status === 404) {
            store.value.commit('flash/error', {
              text: 'Không tìm thấy ghi chép'
            })
          }
        })
    }

    const editActivity = () => {
      loading.value = true
      errors.value = {}
      const activity = formRef.value.getData()
      store.value
        .dispatch('activities/editActivity', {
          activityId: activityId.value,
          activity
        })
        .then(_ => {
          store.value.commit('flash/success', {
            text: 'Sửa ghi chép thành công'
          })
          ctx.root.$router.push(getRouteToActivitiesPage())
        })
        .catch(err => {
          if (err.response && err.response.status === 422) {
            store.value.commit('flash/error', {
              text: 'Vui lòng kiểm tra lại dữ liệu nhập vào'
            })
            errors.value = err.response.data.data.parsedErrors
          }
        })
        .finally(() => {
          loading.value = false
        })
    }

    const deleteActivity = () => {
      loading.value = true
      store.value
        .dispatch('activities/deleteActivity', { activityId: activityId.value })
        .then(_ => {
          store.value.commit('flash/success', {
            text: 'Xóa ghi chép thành công'
          })
          ctx.root.$router.push(getRouteToActivitiesPage())
        })
        .catch(err => {
          if (err.response && err.response.status === 404) {
            ctx.root.$store.commit('flash/error', {
              text: 'Không tìm thấy ghi chép'
            })
          }
        })
        .finally(() => {
          loading.value = false
        })
    }

    onMounted(() => {
      getActivity()
    })

    return {
      formRef,
      activity,
      errors,
      loading,
      date,
      type,
      component,
      title,
      activityId,
      getRouteToActivitiesPage,
      getActivity,
      editActivity,
      deleteActivity
    }
  }
})
</script>
