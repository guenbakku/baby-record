<template>
  <router-link :to="editRoute" tag="div" class="item">
    <v-list-tile>
      <v-list-tile-avatar>
        <sex-icon color="grey" large :sex-id="baby.sex_id" />
      </v-list-tile-avatar>

      <v-list-tile-content>
        <v-list-tile-title>{{ baby.name }}</v-list-tile-title>
        <v-list-tile-sub-title>
          {{ baby.birthday | moment('L') }} ({{ age }})
        </v-list-tile-sub-title>
      </v-list-tile-content>

      <v-list-tile-action>
        <v-icon>keyboard_arrow_right</v-icon>
      </v-list-tile-action>
    </v-list-tile>
  </router-link>
</template>

<script lang="ts">
import { defineComponent, computed, SetupContext } from '@vue/composition-api'
import { useStore } from '@u3u/vue-hooks'
import { Baby, initBaby } from './models'
import { RootState } from '~/store/models'
import useDateTime from '~/hooks/use-date-time'
import SexIcon from '~/components/core/SexIcon.vue'

type Props = {
  baby: Baby
}

export default defineComponent({
  components: { SexIcon },
  props: {
    baby: {
      type: Object as () => Props['baby'],
      default: () => initBaby()
    }
  },
  setup(props: Props, ctx: SetupContext) {
    const store = useStore<RootState>()

    // $moment inside $store is a hack to bypass type checking
    const { calcAge } = useDateTime(store.value.$moment)

    const editRoute = computed(() => ({
      name: 'babies-edit-id',
      params: {
        id: props.baby.id
      }
    }))

    const age = computed(() => {
      const today = ctx.root
        .$moment()
        .startOf('day')
        .toJSON()

      const birthday = ctx.root
        .$moment(props.baby.birthday)
        .startOf('day')
        .toJSON()

      const age = calcAge(birthday, today)
      return age[0] > 0
        ? `${age[0]} tuổi ${age[1]} tháng`
        : `${age[1]} tháng ${age[2]} ngày`
    })

    return {
      editRoute,
      age
    }
  }
})
</script>

<style scoped lang="stylus">
.item {
  padding: 10px 0;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  cursor: pointer;

  &:active {
    background: rgba(255, 255, 255, 0.3);
  }

  &:first-child {
    border-top: none;
  }
}
</style>
