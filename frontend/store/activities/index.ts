import qs from 'qs'
import axios, { AxiosResponse, CancelTokenSource } from 'axios'
import { MutationTree, ActionTree } from 'vuex'
import { RootState, AddResponse, EditResponse, DeleteResponse } from '../models'
import { State, ActivityIndexResponse, ActivityViewResponse } from './models'

export const state = (): State => ({
  date: null,
  activities: [],
  cancelTokenSources: {}
})

export const mutations: MutationTree<State> = {
  setDate(state: State, { date }: { date: string }) {
    state.date = date
  },
  setActivities(
    state: State,
    { activities }: { activities: State['activities'] }
  ) {
    state.activities = activities
  },
  setCancelTokenSource(
    state: State,
    {
      key,
      cancelTokenSource
    }: { key: string; cancelTokenSource: CancelTokenSource }
  ) {
    state.cancelTokenSources = {
      ...state.cancelTokenSources,
      [key]: cancelTokenSource
    }
  }
}

export const actions: ActionTree<State, RootState> = {
  /**
   * Get activities of provided babyId in provided date
   * @param {Object} param0
   * @param {Object} param1
   */
  getActivities(
    { commit },
    { babyId, date }: { babyId: string; date: string }
  ) {
    const cancelTokenSource = axios.CancelToken.source()
    commit('setCancelTokenSource', {
      key: 'getActivities',
      cancelTokenSource
    })

    const showDate = this.$moment(date)
    const from = showDate.toISOString()
    const to = showDate
      .hour(23)
      .minute(59)
      .second(59)
      .toISOString()

    return this.$axios
      .get<any, AxiosResponse<ActivityIndexResponse>>('/activities', {
        params: {
          baby_id: babyId,
          filter: { from, to },
          limit: 999,
          sort: 'started',
          direction: 'desc'
        },
        paramsSerializer(params) {
          return qs.stringify(params, { arrayFormat: 'brackets' })
        },
        cancelToken: cancelTokenSource.token
      })
      .then(function(res) {
        commit('setActivities', { activities: res.data.data })
        return res
      })
  },

  /**
   * Add activity of provided babyId to database
   * @param {Object} param0
   * @param {Object} param1
   */
  addActivity(_, { babyId, activity }: { babyId: string; activity: any }) {
    return this.$axios.post<any, AxiosResponse<AddResponse>>(
      'activities',
      activity,
      {
        params: { baby_id: babyId }
      }
    )
  },

  /**
   * View activity
   * @param {Object} param0
   * @param {Object} param1
   */
  viewActivity(_, { activityId }: { activityId: string }) {
    return this.$axios.get<any, AxiosResponse<ActivityViewResponse>>(
      `activities/${activityId}`
    )
  },

  /**
   * Edit activity
   * @param {Object} param0
   * @param {Object} param1
   */
  editActivity(
    _,
    { activityId, activity }: { activityId: string; activity: any }
  ) {
    return this.$axios.put<any, AxiosResponse<EditResponse>>(
      `activities/${activityId}`,
      activity
    )
  },

  /**
   * Delete activity
   * @param {Object} param0
   * @param {Object} param1
   */
  deleteActivity(_, { activityId }: { activityId: string }) {
    return this.$axios.delete<any, AxiosResponse<DeleteResponse>>(
      `activities/${activityId}`
    )
  }
}
