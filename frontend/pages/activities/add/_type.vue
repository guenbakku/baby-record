<template>
  <v-layout row nowrap>
    <v-flex xs12>
      <v-card>
        <v-card-actions>
          <v-btn icon :to="activitiesPageRoute" active-class="dummy">
            <v-icon>keyboard_arrow_left</v-icon>
          </v-btn>
          <span class="subheading">Thêm {{ title.toLowerCase() }}</span>
        </v-card-actions>
        <v-divider />
        <v-card-text>
          <component :is="component" ref="form" :errors="errors" />
        </v-card-text>
        <v-divider />
        <v-card-actions>
          <v-btn color="success" :loading="loading" @click="addActivity">
            Thêm
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-flex>
  </v-layout>
</template>

<script>
import { loadComponents, getMaps } from '~/components/activity-forms/maps'

export default {
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
    },
    activitiesPageRoute: function() {
      return { name: 'activities-date', params: { date: this.date } }
    }
  },
  methods: {
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
          this.$router.push(this.activitiesPageRoute)
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
    }
  }
}
</script>
