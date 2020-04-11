<template>
  <v-layout row wrap class="pd-5">
    <v-flex xs12>
      <v-card>
        <loading v-if="!completed" />
        <no-data v-else-if="isNoData">
          Chưa có thông tin em bé nào cả. <br />
          Hãy thêm thông tin em bé để bắt đầu sử dụng.
        </no-data>
        <baby-list v-else :babies="babies" />
      </v-card>
    </v-flex>
    <v-btn fixed dark fab bottom right color="success" :to="addRoute">
      <v-icon>add</v-icon>
    </v-btn>
  </v-layout>
</template>

<script lang="ts">
import { defineComponent, ref, computed, onMounted } from '@vue/composition-api'
import { useStore } from '@u3u/vue-hooks'
import { Location } from 'vue-router'
import BabyList from '~/components/babies/BabyList.vue'
import Loading from '~/components/core/card-text/Loading.vue'
import NoData from '~/components/core/card-text/NoData.vue'
import { RootState } from '~/store/models'

export default defineComponent({
  components: { BabyList, Loading, NoData },
  setup() {
    const store = useStore<RootState>()

    const completed = ref<boolean>(false)
    const babies = computed(() => {
      return store.value.state.babies.babies
    })
    const isNoData = computed(() => {
      return completed.value && Object.keys(babies.value || {}).length === 0
    })
    const addRoute = computed((): Location => ({ name: 'babies-add' }))

    const getBabies = () => {
      completed.value = false
      store.value.dispatch('babies/getBabies').finally(() => {
        completed.value = true
      })
    }

    onMounted(getBabies)

    return {
      completed,
      babies,
      isNoData,
      addRoute
    }
  }
})
</script>
