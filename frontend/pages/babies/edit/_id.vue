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
              ref="formRef"
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
import {
  createComponent,
  ref,
  computed,
  SetupContext,
  onMounted
} from '@vue/composition-api'
import { Location } from 'vue-router'
import useInitializationStatus from '~/hooks/use-initialization-status'
import Loading from '~/components/core/card-text/Loading.vue'
import Error from '~/components/core/card-text/Error.vue'
import DoubleConfirmDialog from '~/components/core/DoubleConfirmDialog.vue'
import BabyForm from '~/components/babies/BabyForm.vue'
import { BabyError } from '~/components/babies/models'
import { Baby } from '~/store/babies/models'

export default createComponent({
  components: { Loading, Error, DoubleConfirmDialog, BabyForm },
  setup(_, ctx: SetupContext) {
    const {
      isInitializing,
      isInitializationSuccess,
      isInitializationError,
      setInitializing,
      setInitializationSuccess,
      setInitializationError
    } = useInitializationStatus()

    const formRef = ref<any>(undefined)
    const baby = ref<Baby | undefined>(undefined)
    const errors = ref<BabyError>({})
    const loading = ref<boolean>(false)
    const formInitialized = ref<boolean>(false)

    const babyId = computed(() => ctx.root.$route.params.id)
    const listRoute = computed<Location>(() => ({
      name: 'babies'
    }))

    const getBaby = () => {
      return ctx.root.$store
        .dispatch('babies/viewBaby', { babyId: babyId.value })
        .then(res => {
          baby.value = res.data.data
          return res
        })
        .catch(err => {
          if (err.response && err.response.status === 404) {
            ctx.root.$store.commit('flash/error', {
              text: 'Không tìm thấy thông tin'
            })
          }
          throw err
        })
    }

    const editBaby = () => {
      loading.value = true
      errors.value = {}
      const baby = formRef.value.getData() // TODO: declare form type
      ctx.root.$store
        .dispatch('babies/editBaby', {
          babyId: babyId.value,
          baby
        })
        .then(_ => {
          ctx.root.$store.commit('flash/success', {
            text: 'Sửa thông tin em bé thành công'
          })
          ctx.root.$router.push(listRoute.value)
        })
        .catch(err => {
          if (err.response && err.response.status === 422) {
            ctx.root.$store.commit('flash/error', {
              text: 'Vui lòng kiểm tra lại dữ liệu nhập vào'
            })
            errors.value = err.response.data.data.parsedErrors
          }
        })
        .finally(() => {
          loading.value = false
        })
    }

    const deleteBaby = () => {
      loading.value = true
      ctx.root.$store
        .dispatch('babies/deleteBaby', { babyId: babyId.value })
        .then(_ => {
          ctx.root.$store.commit('flash/success', {
            text: 'Xóa thông tin em bé thành công'
          })
          ctx.root.$router.push(listRoute.value)
        })
        .catch(err => {
          if (err.response && err.response.status === 404) {
            ctx.root.$store.commit('flash/error', {
              text: 'Không tìm thấy thông tin'
            })
          }
        })
        .then(() => {
          loading.value = false
        })
    }

    onMounted(() => {
      setInitializing()
      Promise.all([getBaby()])
        .then(_ => {
          setInitializationSuccess()
        })
        .catch(_ => {
          setInitializationError()
        })
    })

    return {
      isInitializing,
      isInitializationSuccess,
      isInitializationError,
      setInitializing,
      setInitializationSuccess,
      setInitializationError,
      formRef,
      baby,
      errors,
      loading,
      formInitialized,
      babyId,
      listRoute,
      getBaby,
      editBaby,
      deleteBaby
    }
  }
})
</script>
