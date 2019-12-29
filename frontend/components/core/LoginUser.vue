<template>
  <v-toolbar flat class="transparent">
    <v-list class="pa-0">
      <v-list-tile avatar>
        <v-list-tile-avatar>
          <img src="~assets/avatar-it.jpg" />
        </v-list-tile-avatar>
        <v-list-tile-content>
          <v-list-tile-title>{{
            profile ? profile.name : ''
          }}</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
    </v-list>
  </v-toolbar>
</template>

<script lang="ts">
import { createComponent, computed } from '@vue/composition-api'
import { useStore } from '@u3u/vue-hooks'
import { RootState } from '~/store/models'

export default createComponent({
  setup() {
    const store = useStore<RootState>()
    const profile = computed(() => store.value.state.auth.profile)

    return { profile }
  }
})
</script>
