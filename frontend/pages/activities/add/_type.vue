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
    loading: false
  }),
  computed: {
    component: function() {
      return getMaps()[this.$route.params.type].component
    },
    title: function() {
      return getMaps()[this.$route.params.type].title
    },
    date: function() {
      return this.$store.state.activities.date
    }
  },
  methods: {
    getRouteToActivitiesPage: function(date = undefined) {
      date = date || this.date
      return { name: 'activities-date', params: { date } }
    },
    addActivity: function() {
      this.loading = true
      this.errors = {}
      const babyId = this.$store.getters['babies/current'].id
      const activity = this.$refs.form.getData()
      this.$store
        .dispatch('activities/addActivity', {
          babyId,
          activity
        })
        .then(res => {
          this.$store.commit('flash/success', {
            text: 'Thêm ghi chép thành công'
          })
          const date = this.$moment(activity.started).format('YYYY-MM-DD')
          const route = this.getRouteToActivitiesPage(date)
          this.$router.push(route)
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
