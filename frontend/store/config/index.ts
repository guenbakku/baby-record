import { MutationTree } from 'vuex'
import { State } from './models'

export const state = (): State => ({
  headerTitle: null,
  useBabySwitch: false,
  locale: null
})

export const mutations: MutationTree<State> = {
  setHeaderTitle(state, { value }: { value: string }) {
    state.headerTitle = value
  },
  setUseBabySwitch(state, { value }: { value: boolean }) {
    state.useBabySwitch = value
  },
  setLocale(state, { value }: { value: string }) {
    state.locale = value
  }
}
