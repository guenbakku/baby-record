<template>
  <v-layout row nowrap>
    <v-flex xs12>
      <v-card>
        <v-card-actions>
          <v-btn icon :to="{ name: 'activities' }" :active-class="'dummy'">
            <v-icon>keyboard_arrow_left</v-icon>
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
        <v-card-actions>
          <v-btn color="success" @click="editActivity">
            Sửa
          </v-btn>
          <v-spacer />
          <v-btn color="red" @click="addActivity">
            Xóa
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-flex>
  </v-layout>
</template>

<script>
import { loadComponents, getMaps } from '~/components/forms/maps'

export default {
  components: {
    ...loadComponents()
  },
  data: () => ({
    activity: undefined,
    errors: {}
  }),
  computed: {
    component: function() {
      return getMaps()[this.$route.params.type].component
    },
    title: function() {
      return getMaps()[this.$route.params.type].title
    },
    activityId: function() {
      return this.$route.params.id
    }
  },
  mounted: function() {
    this.getActivity()
  },
  methods: {
    getActivity: function() {
      this.$store
        .dispatch('activities/viewActivity', { activityId: this.activityId })
        .then(res => {
          this.activity = res.data.data
        })
        .catch(err => {
          if (err.response && err.response.status === 404) {
            this.$store.commit('flash/error', {
              text: 'Không tìm thấy dữ liệu'
            })
          }
        })
    },
    editActivity: function() {
      this.$nuxt.$loading.start()
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
          this.$nuxt.$loading.finish()
          this.$router.push({ name: 'activities' })
        })
        .catch(err => {
          if (err.response && err.response.status === 422) {
            this.$store.commit('flash/error', {
              text: 'Vui lòng kiểm tra lại dữ liệu nhập vào'
            })
            this.errors = err.response.data.data.parsedErrors
          }
        })
    }
  }
}
</script>
