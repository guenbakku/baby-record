<template>
  <div v-if="currentBaby">
    <v-menu :nudge-width="100">
      <template v-slot:activator="{ on }">
        <div v-on="on">
          <span class="name">{{ currentBaby.name }}</span>
          <v-avatar :tile="false" size="30px">
            <sex-icon :sex-id="currentBaby.sex_id" />
          </v-avatar>
        </div>
      </template>

      <v-list>
        <v-list-tile avatar>
          <v-list-tile-avatar>
            <sex-icon large :sex-id="currentBaby.sex_id" />
          </v-list-tile-avatar>

          <v-list-tile-content>
            <v-list-tile-title>{{ currentBaby.name }}</v-list-tile-title>
            <v-list-tile-sub-title>{{ age }}</v-list-tile-sub-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list>
      <v-divider />
      <v-list>
        <v-list-tile
          v-for="(baby, id) in babies"
          :key="id"
          @click="changeBaby(id)"
        >
          <v-list-tile-title>{{ baby.name }}</v-list-tile-title>
        </v-list-tile>
      </v-list>
    </v-menu>
  </div>
</template>

<script lang="ts">
import { createComponent, computed } from '@vue/composition-api'
import { useStore } from '@u3u/vue-hooks'
import useDateTime from '~/hooks/datetime'
import SexIcon from '~/components/core/SexIcon.vue'
import { RootState } from '~/store/models'
import { Baby } from '~/store/babies/models'

export default createComponent({
  components: { SexIcon },
  setup() {
    const store = useStore<RootState>()

    // $moment inside $store is a hack to bypass type checking
    const { calcAge } = useDateTime(store.value.$moment)

    const currentBaby = computed(
      () => store.value.getters['babies/current'] as Baby
    )

    const babies = computed(() => store.value.state.babies.babies)

    const age = computed(() => {
      const age = calcAge(currentBaby.value.birthday)
      return age[0] > 0
        ? `${age[0]} tuổi ${age[1]} tháng`
        : `${age[1]} tháng ${age[2]} ngày`
    })

    const changeBaby = (id: string) => {
      store.value.commit('babies/setCurrentId', { id })
    }

    return {
      currentBaby,
      babies,
      age,
      changeBaby
    }
  }
})
</script>

<style>
.name {
  display: inline-block;
  vertical-align: middle;
  max-width: 100px;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}
</style>
