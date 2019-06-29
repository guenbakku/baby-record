<template>
  <v-toolbar flat class="transparent">
    <v-list class="pa-0">
      <v-list-tile avatar>
        <v-list-tile-avatar>
          <img src="https://randomuser.me/api/portraits/lego/5.jpg" />
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
