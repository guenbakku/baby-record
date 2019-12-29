<template>
  <v-layout row nowrap>
    <v-flex xs12>
      <v-card>
        <v-form @submit.prevent="addActivity">
          <v-card-actions>
            <v-btn icon :to="getRouteToActivitiesPage()" active-class="dummy">
              <v-icon>keyboard_backspace</v-icon>
            </v-btn>
            <span class="subheading">Thêm {{ title.toLowerCase() }}</span>
          </v-card-actions>
          <v-divider />
          <v-card-text>
            <component :is="component" ref="form" :errors="errors" />
          </v-card-text>
          <v-card-text class="pt-0 pb-0"><v-divider /></v-card-text>
          <v-card-text>
            <v-select
              v-model="copyTargetBabieIds"
              label="Copy ghi chép"
              item-text="name"
              item-value="id"
              :items="copyableBabies"
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
            <v-btn type="submit" color="success" :loading="loading">
              Thêm
            </v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-flex>
  </v-layout>
</template>

<script>
import { loadComponents, getMaps } from '~/components/activity-forms/maps'

export default {
  useBabySwitch: true,
  components: {
    ...loadComponents()
  },
  validate({ params }) {
    return params.type && getMaps()[params.type]
  },
  data: () => ({
    errors: {},
    loading: false,
    copyTargetBabieIds: []
  }),
  computed: {
    component() {
      return getMaps()[this.$route.params.type].component
    },
    title() {
      return getMaps()[this.$route.params.type].title
    },
    date() {
      return this.$store.state.activities.date
    },
    currentBabyId() {
      const currentBaby = this.$store.getters['babies/current']
      return currentBaby ? currentBaby.id : undefined
    },
    copyableBabies() {
      return Object.values(this.$store.state.babies.babies).filter(
        b => b.id !== this.currentBabyId
      )
    }
  },
  watch: {
    currentBabyId(val) {
      this.copyTargetBabieIds = this.copyTargetBabieIds.filter(id => id !== val)
    }
  },
  methods: {
    getRouteToActivitiesPage(date = undefined) {
      date = date || this.date
      return { name: 'activities-date', params: { date } }
    },
    addActivity() {
      this.loading = true
      this.errors = {}
      const babyId = this.currentBabyId
      const activity = this.$refs.form.getData()

      // Save record of main baby first in order to handle validation error efficiently,
      // then copy same record to other copy target babies.
      this.$store
        .dispatch('activities/addActivity', {
          babyId,
          activity
        })
        .then(_ => {
          const promises = this.copyTargetBabieIds.map(babyId => {
            return this.$store.dispatch('activities/addActivity', {
              babyId,
              activity
            })
          })
          return Promise.allSettled(promises)
            .then(results => {
              const errorBabyNames = results
                .filter(result => result.status === 'rejected')
                .map(result => {
                  const err = result.reason
                  const babyId = err.config.params.baby_id
                  const babies = this.$store.state.babies.babies
                  return babies[babyId] ? babies[babyId].name : undefined
                })
                .filter(babyName => !!babyName)

              return errorBabyNames
            })
            .then(errorBabyNames => {
              if (errorBabyNames.length === 0) {
                this.$store.commit('flash/success', {
                  text: 'Thêm ghi chép thành công'
                })
              } else {
                this.$store.commit('flash/error', {
                  text: `Không thể copy ghi chép cho em bé: ${errorBabyNames.join(
                    ', '
                  )}`
                })
              }

              const date = this.$moment(activity.started).format('YYYY-MM-DD')
              const route = this.getRouteToActivitiesPage(date)
              this.$router.push(route)
            })
        })
        .catch(err => {
          if (err.response && err.response.status === 422) {
            this.$store.commit('flash/error', {
              text: 'Vui lòng kiểm tra lại dữ liệu nhập vào'
            })
            this.errors = err.response.data.data.parsedErrors
          }
        })
        .finally(() => {
          this.loading = false
        })
    }
  }
}
</script>
