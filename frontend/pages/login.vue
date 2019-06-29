<template>
  <div>
    <div class="brand">BABY RECORD</div>
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

<script>
export default {
  data() {
    return {
      form: {
        email: null,
        password: null
      },
      loading: false
    }
  },
  fetch({ redirect, store }) {
    if (store.getters['auth/token']) {
      redirect(302, { name: 'activities-date' })
    }
  },
  methods: {
    authenticate() {
      this.loading = true
      this.$store
        .dispatch('auth/authenticate', this.form)
        .then(res => {
          this.$router.push({ name: 'activities-date' })
        })
        .catch(err => {
          if (err.response && err.response.status === 401) {
            this.$store.commit('flash/error', {
              text: 'Email hoặc mật khẩu đăng nhập không chính xác.'
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
