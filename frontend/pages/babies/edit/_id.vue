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
          <v-card-text v-if="!isInitializationError">
            <baby-form
              ref="form"
              :errors="errors"
              :data="baby"
              @initialized="formInitialized = true"
            />
          </v-card-text>
          <error v-if="isInitializationError" />
          <v-divider />
          <loading v-if="isInitializing || !formInitialized" />
          <v-card-actions v-if="isInitializationSuccess && formInitialized">
            <v-btn type="submit" color="success" :loading="loading">
              Sửa
            </v-btn>
            <v-spacer />
            <double-confirm-dialog
              :v-if="isInitializationSuccess"
              :loading="loading"
              :check-value="baby.name"
              @confirmed="deleteBaby()"
            >
              <template v-slot:activator="{ on }">
                <v-btn color="error" :loading="loading" v-on="on">Xóa</v-btn>
              </template>
              <template v-slot:message>
                <div>
                  Bạn có chắc chắn muốn xóa thông tin em bé này? Tất cả ghi chép
                  của em bé đều sẽ bị xóa. Hãy nhập tên em bé
                  <b>"{{ baby.name }}"</b> vào ô bên dưới để xác nhận.
                </div>
              </template>
            </double-confirm-dialog>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-flex>
  </v-layout>
</template>

<script>
import Loading from '~/components/core/card-text/Loading'
import Error from '~/components/core/card-text/Error'
import DoubleConfirmDialog from '~/components/core/DoubleConfirmDialog'
import BabyForm from '~/components/babies/BabyForm'
import InitializationStatusMixin from '~/mixins/initialization-status.mixin'

export default {
  components: { Loading, Error, DoubleConfirmDialog, BabyForm },
  mixins: [InitializationStatusMixin],
  data: () => ({
    baby: undefined,
    errors: {},
    loading: false,
    formInitialized: false
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
    this.setInitializing()
    Promise.all([this.getBaby()])
      .then(res => {
        this.setInitializationSuccess()
      })
      // eslint-disable-next-line handle-callback-err
      .catch(err => {
        this.setInitializationError()
      })
  },
  methods: {
    getBaby: function() {
      return this.$store
        .dispatch('babies/viewBaby', { babyId: this.babyId })
        .then(res => {
          this.baby = res.data.data
          return res
        })
        .catch(err => {
          if (err.response && err.response.status === 404) {
            this.$store.commit('flash/error', {
              text: 'Không tìm thấy thông tin'
            })
          }
          throw err
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
        .finally(() => {
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
