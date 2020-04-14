import { AxiosResponse } from 'axios'
import { GetterTree, MutationTree, ActionTree } from 'vuex'
import { RootState, AddResponse, EditResponse, DeleteResponse } from '../models'
import { State, Baby, BabyIndexResponse, BabyViewResponse } from './models'

const STORAGE_CURRENT_BABY_ID = 'current_baby_id'

export const state = (): State => ({
  currentId: null,
  babies: {}
})

export const getters: GetterTree<State, RootState> = {
  current(state): Baby | null {
    const currentId = state.currentId
    if (currentId && state.babies[currentId]) {
      return state.babies[currentId]
    }

    if (state.babies) {
      const firstId = Object.keys(state.babies)[0]
      return state.babies[firstId]
    }

    return null
  }
}

export const mutations: MutationTree<State> = {
  setCurrentId(state, { id }: { id: string }) {
    window.localStorage.setItem(STORAGE_CURRENT_BABY_ID, id)
    state.currentId = id
  },
  removeCurrentId(_) {
    window.localStorage.removeItem(STORAGE_CURRENT_BABY_ID)
  },
  setBabies(state, { babies }: { babies: Baby[] }) {
    const data: State['babies'] = {}
    for (const baby of babies) {
      data[baby.id] = {
        ...baby,
        // TODO: remove this line
        avatar: 'https://vuetifyjs.com/apple-touch-icon-180x180.png'
      }
    }
    state.babies = data
  },
  clearAll(state) {
    state.currentId = null
    state.babies = {}
  },
  loadFromLocalStorage(state) {
    state.currentId = window.localStorage.getItem(STORAGE_CURRENT_BABY_ID)
  }
}

export const actions: ActionTree<State, RootState> = {
  /**
   * Get babies list
   * @param param0 - object param 0
   */
  getBabies({ commit }) {
    return this.$axios
      .get<any, AxiosResponse<BabyIndexResponse>>('babies', {
        params: {
          sort: 'created',
          direction: 'asc'
        }
      })
      .then(function(res) {
        commit('setBabies', { babies: res.data.data })
        return res
      })
  },

  /**
   * Add baby
   * @param param0 - object param 0
   * @param param1 - object param 1
   */
  addBaby(_, { baby }: { baby: Baby }) {
    return this.$axios.post<any, AxiosResponse<AddResponse>>('babies', baby)
  },

  /**
   * View baby
   * @param param0 - object param 0
   * @param param1 - object param 1
   */
  viewBaby(_, { babyId }: { babyId: string }) {
    return this.$axios.get<any, AxiosResponse<BabyViewResponse>>(
      `babies/${babyId}`
    )
  },

  /**
   * Edit baby
   * @param param0 - object param 0
   * @param param1 - object param 1
   */
  editBaby(_, { babyId, baby }: { babyId: string; baby: Baby }) {
    return this.$axios.put<any, AxiosResponse<EditResponse>>(
      `babies/${babyId}`,
      baby
    )
  },

  /**
   * Delete baby
   * @param param0 - object param 0
   * @param param1 - object param 1
   */
  deleteBaby(_, { babyId }: { babyId: string }) {
    return this.$axios.delete<any, AxiosResponse<DeleteResponse>>(
      `babies/${babyId}`
    )
  }
}
