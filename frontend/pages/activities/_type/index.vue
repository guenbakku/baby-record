<template>
  <v-layout row nowrap>
    <v-flex xs12>
      <v-card>
        <v-card-actions>
          <v-btn icon :to="{ name: 'activities' }" :active-class="'dummy'">
            <v-icon>keyboard_arrow_left</v-icon>
          </v-btn>
          <span class="subheading">{{ title }}</span>
        </v-card-actions>
        <v-divider />
        <v-card-text>
          <component :is="component" ref="form" :errors="errors" />
        </v-card-text>
        <v-divider />
        <v-card-actions>
          <v-btn color="green" @click="addActivity">
            Gửi
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
    errors: {}
  }),
  computed: {
    component: function() {
      return getMaps()[this.$route.params.type].component
    },
    title: function() {
      return getMaps()[this.$route.params.type].title
    }
  },
  methods: {
    addActivity: function() {
      this.$nuxt.$loading.start()
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
