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
              ref="form"
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

<script>
import { loadComponents, getMaps } from '~/components/activity-forms/maps'
import ConfirmDialog from '~/components/core/ConfirmDialog'

export default {
  useBabySwitch: true,
  components: {
    ...loadComponents(),
    ConfirmDialog
  },
  data: () => ({
    activity: undefined,
    errors: {},
    loading: false
  }),
  computed: {
    date() {
      return this.$store.state.activities.date
    },
    type() {
      return this.activity ? this.activity.activity_type.code : undefined
    },
    component() {
      return this.type ? getMaps()[this.type].component : undefined
    },
    title() {
      return this.type ? getMaps()[this.type].title : ''
    },
    activityId() {
      return this.$route.params.id
    }
  },
  mounted() {
    this.getActivity()
  },
  methods: {
    test() {
      alert('OK')
    },
    getRouteToActivitiesPage(date = undefined) {
      date = date || this.date
      return { name: 'activities-date', params: { date } }
    },
    getActivity() {
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
    editActivity() {
      this.loading = true
      this.errors = {}
      const activity = this.$refs.form.getData()
      this.$store
        .dispatch('activities/editActivity', {
          activityId: this.activityId,
          activity
        })
        .then(_ => {
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
        .finally(() => {
          this.loading = false
        })
    },
    deleteActivity() {
      this.loading = true
      this.$store
        .dispatch('activities/deleteActivity', { activityId: this.activityId })
        .then(_ => {
          this.$store.commit('flash/success', {
            text: 'Xóa ghi chép thành công'
          })
          this.$router.push(this.getRouteToActivitiesPage())
        })
        .catch(err => {
          if (err.response && err.response.status === 404) {
            this.$store.commit('flash/error', {
              text: 'Không tìm thấy ghi chép'
            })
          }
        })
        .finally(() => {
          this.loading = false
        })
    }
  }
}
</script>
