<template>
  <v-snackbar v-model="snackbar" :color="color" :timeout="timeout" top>
    {{ text }}
    <v-btn dark flat @click="snackbar = false">
      <v-icon>close</v-icon>
    </v-btn>
  </v-snackbar>
</template>

<script lang="ts">
import { createComponent, ref, computed } from '@vue/composition-api'
import { useStore } from '@u3u/vue-hooks'
import { RootState } from '~/store/models'

export default createComponent({
  setup() {
    const store = useStore<RootState>()

    const timeout = ref(6000)
    const snackbar = computed({
      get() {
        return store.value.state.flash.show
      },
      set() {
        store.value.commit('flash/hide')
      }
    })
    const text = computed(() => store.value.state.flash.text)
    const color = computed(() => store.value.getters['flash/color'])

    return {
      timeout,
      snackbar,
      text,
      color
    }
  }
})
</script>
