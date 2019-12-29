import qs from 'qs'
import axios from 'axios'
import { MutationTree, ActionTree } from 'vuex'

export type State = {
  date: string | undefined
  activities: any[] // TODO: declare types
  cancelTokenSources: any // TODO
}

export const state = (): State => ({
  date: undefined,
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
    { key, cancelTokenSource }: { key: string; cancelTokenSource: any }
  ) {
    state.cancelTokenSources = {
      ...state.cancelTokenSources,
      [key]: cancelTokenSource
    }
  }
}

export const actions: ActionTree<State, State> = {
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
      .get('/activities', {
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
  addActivity(
    _,
    { babyId, activity }: { babyId: string; activity: State['activities'] }
  ) {
    return this.$axios.post('activities', activity, {
      params: { baby_id: babyId }
    })
  },

  /**
   * View activity
   * @param {Object} param0
   * @param {Object} param1
   */
  viewActivity(_, { activityId }) {
    return this.$axios.get(`activities/${activityId}`)
  },

  /**
   * Edit activity
   * @param {Object} param0
   * @param {Object} param1
   */
  editActivity(_, { activityId, activity }) {
    return this.$axios.put(`activities/${activityId}`, activity)
  },

  /**
   * Delete activity
   * @param {Object} param0
   * @param {Object} param1
   */
  deleteActivity(_, { activityId }) {
    return this.$axios.delete(`activities/${activityId}`)
  }
}
