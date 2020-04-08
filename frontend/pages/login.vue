<template>
  <div>
    <div class="brand">{{ brand }}</div>
    <v-card flat>
      <v-card-text>
        <v-form @submit.prevent="authenticate">
          <v-text-field
            v-model="form.email"
            prepend-icon="email"
            name="Email"
            label="Email"
          >
          </v-text-field>
          <v-text-field
            v-model="form.password"
            prepend-icon="lock"
            name="Password"
            label="Mật khẩu"
            type="password"
          >
          </v-text-field>
          <v-card-actions>
            <v-btn type="submit" color="dark" block :loading="loading">
              Đăng nhập
            </v-btn>
          </v-card-actions>
        </v-form>
      </v-card-text>
    </v-card>
  </div>
</template>

<script lang="ts">
import { createComponent, SetupContext, ref } from '@vue/composition-api'
import { Context } from '@nuxt/types/app'
import { AxiosError } from 'axios'
import pkg from '~/package.json'

type Form = {
  email: string | null
  password: string | null
}

export default createComponent({
  setup(_, ctx: SetupContext) {
    const loading = ref<boolean>(false)
    const brand = pkg.title.toUpperCase()
    const form = ref<Form>({
      email: null,
      password: null
    })

    const authenticate = () => {
      loading.value = true
      ctx.root.$store
        .dispatch('auth/authenticate', form.value)
        .then(_ => {
          ctx.root.$router.push({ name: 'activities-date' })
        })
        .catch((err: AxiosError) => {
          if (err.response && err.response.status === 401) {
            ctx.root.$store.commit('flash/error', {
              text: 'Email hoặc mật khẩu không chính xác'
            })
          }
        })
        .finally(() => {
          loading.value = false
        })
    }

    return { form, loading, brand, authenticate }
  },
  fetch({ redirect, store }: Context): void {
    if (store.getters['auth/isAuthenticated']) {
      redirect({ name: 'activities-date' })
    }
  }
})
</script>

<style lang="stylus" scoped>
.brand {
  text-align: center;
  font-size: 3rem;
  font-weight: 700;
  margin: 3rem 0;
  color: #888;
  text-shadow: -1px -1px 1px rgba(0, 0, 0, .7),
               1px 1px 1px rgba(255, 255, 255, .7);
}
</style>
