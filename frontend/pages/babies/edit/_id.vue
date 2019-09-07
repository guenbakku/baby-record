<template>
  <v-layout row nowrap>
    <v-flex xs12>
      <v-card>
        <v-form @submit.prevent="editBaby">
          <v-card-actions>
            <v-btn icon :to="listRoute" active-class="dummy">
              <v-icon>keyboard_backspace</v-icon>
            </v-btn>
            <span class="subheading">Sửa em bé</span>
          </v-card-actions>
          <v-divider />
          <v-card-text>
            <baby-form v-if="baby" ref="form" :errors="errors" :data="baby" />
            <v-progress-circular v-else indeterminate color="success" />
          </v-card-text>
          <v-divider />
          <v-card-actions v-if="baby">
            <v-btn type="submit" color="success" :loading="loading">
              Sửa
            </v-btn>
            <v-spacer />
            <confirm-button
              :message="'Bạn có chắc chắn muốn xóa thông tin này?'"
              :loading="loading"
              @confirmed="deleteBaby()"
            >
              <template v-slot:activator="{ on }">
                <v-btn color="error" :loading="loading" v-on="on">Xóa</v-btn>
              </template>
            </confirm-button>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-flex>
  </v-layout>
</template>

<script>
import ConfirmButton from '~/components/ConfirmButton'
import BabyForm from '~/components/babies/BabyForm'

export default {
  components: { ConfirmButton, BabyForm },
  data: () => ({
    baby: undefined,
    errors: {},
    loading: false
  }),
  computed: {
    babyId: function() {
      return this.$route.params.id
    },
    listRoute: function() {
      return {
        name: 'babies'
      }
    }
  },
  mounted() {
    this.getBaby()
  },
  methods: {
    getBaby: function() {
      this.$store
        .dispatch('babies/viewBaby', { babyId: this.babyId })
        .then(res => {
          this.baby = res.data.data
        })
        .catch(err => {
          if (err.response && err.response.status === 404) {
            this.$store.commit('flash/error', {
              text: 'Không tìm thấy thông tin'
            })
          }
        })
    },
    editBaby: function() {
      this.loading = true
      this.errors = {}
      const baby = this.$refs.form.getData()
      this.$store
        .dispatch('babies/editBaby', {
          babyId: this.babyId,
          baby
        })
        .then(res => {
          this.$store.commit('flash/success', {
            text: 'Sửa thông tin em bé thành công'
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
        .then(() => {
          this.loading = false
        })
    },
    deleteBaby: function() {
      this.loading = true
      this.$store
        .dispatch('babies/deleteBaby', { babyId: this.babyId })
        .then(res => {
          this.$store.commit('flash/success', {
            text: 'Xóa thông tin em bé thành công'
          })
          this.$router.push(this.listRoute)
        })
        .catch(err => {
          if (err.response && err.response.status === 404) {
            this.$store.commit('flash/error', {
              text: 'Không tìm thấy thông tin'
            })
          }
        })
        .then(() => {
          this.loading = false
        })
    }
  }
}
</script>