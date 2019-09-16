<template>
  <v-layout row nowrap>
    <v-flex xs12>
      <v-card>
        <v-form @submit.prevent="addBaby">
          <v-card-actions>
            <v-btn icon :to="listRoute" active-class="dummy">
              <v-icon>keyboard_backspace</v-icon>
            </v-btn>
            <span class="subheading">Thêm em bé</span>
          </v-card-actions>
          <v-divider />
          <v-card-text>
            <baby-form ref="form" :errors="errors" />
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
import BabyForm from '~/components/babies/BabyForm'

export default {
  components: { BabyForm },
  data() {
    return {
      errors: {},
      loading: false
    }
  },
  computed: {
    listRoute: function() {
      return {
        name: 'babies'
      }
    }
  },
  methods: {
    addBaby: function() {
      this.loading = true
      this.errors = {}
      const baby = this.$refs.form.getData()
      this.$store
        .dispatch('babies/addBaby', { baby })
        .then(res => {
          this.$store.commit('flash/success', {
            text: 'Thêm thông tin em bé thành công'
          })
          this.$router.push(this.listRoute)
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
