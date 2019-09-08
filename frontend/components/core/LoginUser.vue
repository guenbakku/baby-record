<template>
  <v-toolbar flat class="transparent">
    <v-list class="pa-0">
      <v-list-tile avatar>
        <v-list-tile-avatar>
          <img src="~assets/avatar-it.jpg" />
        </v-list-tile-avatar>
        <v-list-tile-content>
          <v-list-tile-title>{{ profile.name }}</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
    </v-list>
  </v-toolbar>
</template>

<script>
import { mapState } from 'vuex'

export default {
  computed: {
    ...mapState('auth', ['profile'])
  }
}
</script>
