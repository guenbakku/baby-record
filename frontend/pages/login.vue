<template>
  <v-card flat>
    <v-card-title primary-title>
      <h3>Login</h3>
    </v-card-title>
    <v-divider />
    <v-card-text>
      <v-form>
        <v-text-field prepend-icon="person" name="Username" label="Username">
        </v-text-field>
        <v-text-field
          prepend-icon="lock"
          name="Password"
          label="Password"
          type="password"
        >
        </v-text-field>
        <v-card-actions>
          <v-btn color="dark" block>Login</v-btn>
        </v-card-actions>
      </v-form>
    </v-card-text>
  </v-card>
</template>
