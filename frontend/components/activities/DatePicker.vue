<template>
  <v-menu v-model="menu" :close-on-content-click="false">
    <template v-slot:activator="{ on }">
      <v-btn icon class="mr-2" @click="subOneDay">
        <v-icon>keyboard_arrow_left</v-icon>
      </v-btn>
      <v-icon>event</v-icon>
      <span class="subheading" v-on="on">{{ mDate | moment('L') }}</span>
      <v-btn icon class="ml-2" @click="addOneDay">
        <v-icon>keyboard_arrow_right</v-icon>
      </v-btn>
    </template>
    <v-date-picker
      v-model="mDate"
      no-title
      :locale="locale"
      :first-day-of-week="1"
      @change="menu = false"
    ></v-date-picker>
  </v-menu>
</template>

<script lang="ts">
import {
  defineComponent,
  computed,
  ref,
  SetupContext
} from '@vue/composition-api'
import { useStore } from '@u3u/vue-hooks'
import { RootState } from '~/store/models'

type Props = {
  date: string | undefined
}

export default defineComponent({
  props: {
    date: {
      type: String as () => Props['date'],
      default: undefined
    }
  },
  setup(props: Props, ctx: SetupContext) {
    const store = useStore<RootState>()
    const menu = ref(false)
    const mDate = computed<string>({
      get() {
        return ctx.root.$moment(props.date).format('YYYY-MM-DD')
      },
      set(date) {
        ctx.emit('selected', date)
      }
    })
    const locale = computed(() => store.value.state.config.locale)

    const subOneDay = () => {
      mDate.value = ctx.root
        .$moment(mDate.value)
        .subtract(1, 'days')
        .format('YYYY-MM-DD')
    }

    const addOneDay = () => {
      mDate.value = ctx.root
        .$moment(mDate.value)
        .add(1, 'days')
        .format('YYYY-MM-DD')
    }

    return {
      menu,
      mDate,
      locale,
      subOneDay,
      addOneDay
    }
  }
})
</script>
