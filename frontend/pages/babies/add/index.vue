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
            <baby-form
              ref="formRef"
              :errors="errors"
              @initialized="formInitialized = true"
            />
          </v-card-text>
          <v-divider />
          <loading v-if="!formInitialized" />
          <v-card-actions v-else>
            <v-btn type="submit" color="success" :loading="loading">
              Thêm
            </v-btn>
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
  SetupContext
} from '@vue/composition-api'
import { Location } from 'vue-router'
import Loading from '~/components/core/card-text/Loading.vue'
import BabyForm from '~/components/babies/BabyForm.vue'
import { BabyError } from '~/components/babies/models'

export default createComponent({
  components: { Loading, BabyForm },
  setup(_, ctx: SetupContext) {
    const formRef = ref<any>(undefined)
    const errors = ref<BabyError>({})
    const loading = ref<boolean>(false)
    const formInitialized = ref<boolean>(false)

    const listRoute = computed<Location>(() => ({
      name: 'babies'
    }))

    const addBaby = () => {
      loading.value = true
      errors.value = {}
      const baby = formRef.value.getData()
      ctx.root.$store
        .dispatch('babies/addBaby', { baby })
        .then(_ => {
          ctx.root.$store.commit('flash/success', {
            text: 'Thêm thông tin em bé thành công'
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

    return {
      formRef,
      errors,
      loading,
      formInitialized,
      listRoute,
      addBaby
    }
  }
})
</script>
