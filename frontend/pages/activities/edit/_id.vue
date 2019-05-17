<template>
  <v-layout row nowrap>
    <v-flex xs12>
      <v-card>
        <v-card-actions>
          <v-btn icon :to="getRouteToActivitiesPage()" active-class="dummy">
            <v-icon>keyboard_backspace</v-icon>
          </v-btn>
          <span class="subheading">Sửa {{ title.toLowerCase() }}</span>
        </v-card-actions>
        <v-divider />
        <v-card-text>
          <component
            :is="component"
            v-if="activity"
            ref="form"
            :data="activity"
            :errors="errors"
          />
          <v-progress-circular v-else indeterminate color="success" />
        </v-card-text>
        <v-divider />
        <v-card-actions v-if="activity">
          <v-btn color="success" :loading="loading" @click="editActivity">
            Sửa
          </v-btn>
          <v-spacer />
          <delete-button
            :activity-id="activity.id"
            @deleted="afterDeletedActivity"
          />
        </v-card-actions>
      </v-card>
    </v-flex>
  </v-layout>
</template>

<script>
import { loadComponents, getMaps } from '~/components/activity-forms/maps'
import DeleteButton from '~/components/activity-forms/DeleteButton'

export default {
  components: {
    ...loadComponents(),
    DeleteButton
  },
  data: () => ({
    activity: undefined,
    errors: {},
    loading: false
  }),
  computed: {
    date: function() {
      return this.$store.state.activities.date
    },
    type: function() {
      return this.activity ? this.activity.activity_type.code : undefined
    },
    component: function() {
      return this.type ? getMaps()[this.type].component : undefined
    },
    title: function() {
      return this.type ? getMaps()[this.type].title : ''
    },
    activityId: function() {
      return this.$route.params.id
    }
  },
  mounted: function() {
    this.getActivity()
  },
  methods: {
    getRouteToActivitiesPage: function(date = undefined) {
      date = date || this.date
      return { name: 'activities-date', params: { date } }
    },
    getActivity: function() {
      this.$store
        .dispatch('activities/viewActivity', { activityId: this.activityId })
        .then(res => {
          this.activity = res.data.data
        })
        .catch(err => {
          if (err.response && err.response.status === 404) {
            this.$store.commit('flash/error', {
              text: 'Không tìm thấy ghi chép'
            })
          }
        })
    },
    editActivity: function() {
      this.loading = true
      this.errors = {}
      const activity = this.$refs.form.getData()
      this.$store
        .dispatch('activities/editActivity', {
          activityId: this.activityId,
          activity
        })
        .then(res => {
          this.$store.commit('flash/success', {
            text: 'Sửa ghi chép thành công'
          })
          this.$router.push(this.getRouteToActivitiesPage())
        })
        .catch(err => {
          if (err.response && err.response.status === 422) {
            this.$store.commit('flash/error', {
              text: 'Vui lòng kiểm tra lại dữ liệu nhập vào'
            })
            this.errors = err.response.data.data.parsedErrors
          }
        })
        .then(() => {
          this.loading = false
        })
    },
    afterDeletedActivity: function() {
      this.$router.push(this.getRouteToActivitiesPage())
    }
  }
}
</script>
