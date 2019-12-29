import qs from 'qs'
import { GetterTree, MutationTree, ActionTree } from 'vuex'
import { AxiosResponse, AxiosRequestConfig } from 'axios'
import { RootState } from '../models'
import { State, User, AuthResponse, MeResponse } from './models'

const STORAGE_TOKEN_KEY = 'token'

export const state = (): State => ({
  token: null,
  profile: {}
})

export const getters: GetterTree<State, RootState> = {
  isAuthenticated(state) {
    return state.token !== null
  }
}

export const mutations: MutationTree<State> = {
  setToken(_, { token }: { token: string }) {
    window.localStorage.setItem(STORAGE_TOKEN_KEY, token)
  },
  removeToken(_) {
    window.localStorage.removeItem(STORAGE_TOKEN_KEY)
  },
  setProfile(state, { profile }: { profile: User }) {
    state.profile = profile
  },
  clearAll(state) {
    state.profile = {}
    state.token = null
  },
  loadFromLocalStorage(state) {
    state.token = window.localStorage.getItem(STORAGE_TOKEN_KEY) || null
  }
}

export const actions: ActionTree<State, RootState> = {
  authenticate(
    { commit },
    { email, password }: { email: string; password: string }
  ) {
    const data = qs.stringify({
      email,
      password
    })
    const config: AxiosRequestConfig = {
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    }
    return this.$axios
      .post<any, AxiosResponse<AuthResponse>>('users/token', data, config)
      .then(res => {
        commit('setToken', { token: res.data.data.token })
        commit('loadFromLocalStorage')
        return res
      })
  },
  getProfile({ commit }) {
    return this.$axios
      .get<any, AxiosResponse<MeResponse>>('users/me')
      .then(res => {
        commit('setProfile', { profile: res.data.data })
        return res
      })
  }
}
