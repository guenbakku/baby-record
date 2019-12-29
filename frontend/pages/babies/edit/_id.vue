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
          <v-card-text v-show="isInitializationSuccess">
            <baby-form
              ref="form"
              :errors="errors"
              :data="baby"
              @initialized="formInitialized = true"
            />
          </v-card-text>
          <error v-if="isInitializationError" />
          <loading v-if="isInitializing || !formInitialized" />
          <v-divider />
          <v-card-actions v-if="isInitializationSuccess && formInitialized">
            <v-btn type="submit" color="success" :loading="loading">
              Sửa
            </v-btn>
            <v-spacer />
            <double-confirm-dialog
              :loading="loading"
              :check-value="baby ? baby.name : ''"
              @confirmed="deleteBaby()"
            >
              <template v-slot:activator="{ on }">
                <v-btn color="error" :loading="loading" v-on="on">Xóa</v-btn>
              </template>
              <template v-slot:message>
                <div>
                  Bạn có chắc chắn muốn xóa thông tin em bé này? Tất cả ghi chép
                  của em bé đều sẽ bị xóa. Hãy nhập tên em bé
                  <b>"{{ baby ? baby.name : '' }}"</b> vào ô bên dưới để xác
                  nhận.
                </div>
              </template>
            </double-confirm-dialog>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-flex>
  </v-layout>
</template>

<script lang="ts">
import Vue from 'vue'
import { Location } from 'vue-router'
import Loading from '~/components/core/card-text/Loading.vue'
import Error from '~/components/core/card-text/Error.vue'
import DoubleConfirmDialog from '~/components/core/DoubleConfirmDialog.vue'
import BabyForm from '~/components/babies/BabyForm.vue'
import InitializationStatusMixin from '~/mixins/initialization-status.mixin'
import { Baby } from '~/store/babies/models'

type Data = {
  baby: Baby | undefined
  errors: any // TODO: declare validation error type
  loading: boolean
  formInitialized: boolean
}

export default Vue.extend({
  components: { Loading, Error, DoubleConfirmDialog, BabyForm },
  mixins: [InitializationStatusMixin],
  data: (): Data => ({
    baby: undefined,
    errors: {},
    loading: false,
    formInitialized: false
  }),
  computed: {
    babyId(): string {
      return this.$route.params.id
    },
    listRoute(): Location {
      return {
        name: 'babies'
      }
    }
  },
  mounted() {
    ;(this as any).setInitializing()
    Promise.all([this.getBaby()])
      .then(_ => {
        ;(this as any).setInitializationSuccess()
      })
      // eslint-disable-next-line handle-callback-err
      .catch(_ => {
        ;(this as any).setInitializationError()
      })
  },
  methods: {
    getBaby() {
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
    editBaby() {
      this.loading = true
      this.errors = {}
      const baby = (this.$refs.form as any).getData() // TODO: declare form type
      this.$store
        .dispatch('babies/editBaby', {
          babyId: this.babyId,
          baby
        })
        .then(_ => {
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
    deleteBaby() {
      this.loading = true
      this.$store
        .dispatch('babies/deleteBaby', { babyId: this.babyId })
        .then(_ => {
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
})
</script>
