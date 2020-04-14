<template>
  <v-layout row nowrap>
    <v-flex xs12>
      <v-card>
        <v-form @submit.prevent="addActivity">
          <v-card-actions>
            <v-btn :to="getRouteToActivitiesPage()" icon active-class="dummy">
              <v-icon>keyboard_backspace</v-icon>
            </v-btn>
            <span class="subheading">Thêm {{ title.toLowerCase() }}</span>
          </v-card-actions>
          <v-divider />
          <v-card-text>
            <component :is="component" ref="formRef" :errors="errors" />
          </v-card-text>
          <v-card-text class="pt-0 pb-0"><v-divider /></v-card-text>
          <v-card-text>
            <v-select
              v-model="copyTargetBabieIds"
              :items="copyableBabies"
              label="Copy ghi chép"
              item-text="name"
              item-value="id"
              deletable-chips
              hide-selected
              multiple
              chips
            >
              <template v-slot:no-data>
                <v-list-tile><em>Không có dữ liệu</em></v-list-tile>
              </template>
            </v-select>
          </v-card-text>
          <v-divider />
          <v-card-actions>
            <v-btn :loading="loading" type="submit" color="success">
              Thêm
            </v-btn>
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
  watch,
  SetupContext
} from '@vue/composition-api'
import { Location } from 'vue-router'
import { Context } from '@nuxt/types/app'
import { useStore } from '@u3u/vue-hooks'
import { RootState } from '~/store/models'
import { loadComponents, getMaps } from '~/components/activity-forms/maps'

export default defineComponent({
  useBabySwitch: true,
  components: {
    ...loadComponents()
  },
  validate({ params }: Context) {
    return params.type !== undefined && getMaps()[params.type] !== undefined
  },
  setup(_, ctx: SetupContext) {
    const store = useStore<RootState>()

    const formRef = ref<any>(null)
    const loading = ref<boolean>(false)
    const errors = ref<any>({}) // TODO: declare type
    const copyTargetBabieIds = ref<string[]>([])

    const component = computed(
      () => getMaps()[ctx.root.$route.params.type].component
    )
    const title = computed(() => getMaps()[ctx.root.$route.params.type].title)
    const date = computed(() => store.value.state.activities.date)
    const currentBabyId = computed<string | undefined>(() => {
      const currentBaby = store.value.getters['babies/current']
      return currentBaby ? currentBaby.id : undefined
    })
    const copyableBabies = computed(() => {
      return Object.values(store.value.state.babies.babies).filter(
        b => b.id !== currentBabyId.value
      )
    })

    watch(currentBabyId, val => {
      copyTargetBabieIds.value = copyTargetBabieIds.value.filter(
        id => id !== val
      )
    })

    const getRouteToActivitiesPage = (inputDate?: string): Location => {
      const paramDate = inputDate || date.value || ''
      return { name: 'activities-date', params: { date: paramDate } }
    }

    const addActivity = () => {
      loading.value = true
      errors.value = {}
      const babyId = currentBabyId.value
      const activity = formRef.value.getData()

      // Save record of main baby first in order to handle validation error efficiently,
      // then copy same record to other copy target babies.
      store.value
        .dispatch('activities/addActivity', {
          babyId,
          activity
        })
        .then(_ => {
          const promises = copyTargetBabieIds.value.map(babyId => {
            return store.value.dispatch('activities/addActivity', {
              babyId,
              activity
            })
          })

          // TODO:
          //  1. remove the hacking of casting Promise to `any` to use `allSettled` here.
          //  2. remove any-casting bellow if possible.
          return (Promise as any)
            .allSettled(promises)
            .then((results: any) => {
              const errorBabyNames = results
                .filter((result: any) => result.status === 'rejected')
                .map((result: any) => {
                  const err = result.reason
                  const babyId = err.config.params.baby_id
                  const babies = store.value.state.babies.babies
                  return babies[babyId] ? babies[babyId].name : undefined
                })
                .filter((babyName: string) => !!babyName)

              return errorBabyNames
            })
            .then((errorBabyNames: any) => {
              if (errorBabyNames.length === 0) {
                store.value.commit('flash/success', {
                  text: 'Thêm ghi chép thành công'
                })
              } else {
                store.value.commit('flash/error', {
                  text: `Không thể copy ghi chép cho em bé: ${errorBabyNames.join(
                    ', '
                  )}`
                })
              }

              // $moment() in ctx.root has an interface that returning void,
              // so we must use the another one from `store` to apply chain-calling here.
              const date = store.value
                .$moment(activity.started)
                .format('YYYY-MM-DD')
              const route = getRouteToActivitiesPage(date)
              ctx.root.$router.push(route)
            })
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

    return {
      formRef,
      loading,
      errors,
      copyTargetBabieIds,
      component,
      title,
      date,
      copyableBabies,
      getRouteToActivitiesPage,
      addActivity
    }
  }
})
</script>
