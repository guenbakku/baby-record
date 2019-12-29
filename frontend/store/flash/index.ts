import { GetterTree, MutationTree } from 'vuex'
import { RootState } from '../models'
import { State, Type, Color } from './models'

export const state = (): State => ({
  text: null,
  type: null,
  show: false
})

export const getters: GetterTree<State, RootState> = {
  color(state) {
    return state.type ? Color[state.type] : null
  }
}

export const mutations: MutationTree<State> = {
  error(state, { text }: { text: string }) {
    state.text = text
    state.type = Type.error
    state.show = true
  },
  success(state, { text }: { text: string }) {
    state.text = text
    state.type = Type.success
    state.show = true
  },
  hide(state) {
    state.show = false
  }
}
