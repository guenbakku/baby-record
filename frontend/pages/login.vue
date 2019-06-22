<template>
  <v-card flat>
    <v-card-title primary-title>
      <h3>Đăng nhập</h3>
    </v-card-title>
    <v-divider />
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
          <v-btn color="dark" block @click="authenticate">Login</v-btn>
        </v-card-actions>
      </v-form>
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  data() {
    return {
      form: {
        email: null,
        password: null
      }
    }
  },
  fetch({ redirect, store }) {
    if (store.getters['auth/token']) {
      redirect(302, { name: 'activities-date' })
    }
  },
  methods: {
    authenticate() {
      this.$store.dispatch('auth/authenticate', this.form).then(res => {
        this.$router.push({ name: 'activities-date' })
      })
    }
  }
}
</script>
