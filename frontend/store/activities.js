import Vue from 'vue'
import qs from 'qs'

export const state = () => ({
  date: undefined,
  activities: []
})

export const mutations = {
  setDate(state, { date }) {
    state.date = date
  },
  setActivities(state, { activities }) {
    state.activities = activities
  }
}

export const actions = {
  /**
   * Get activities of provided babyId in provided date
   * @param {Object} param0
   * @param {Object} param1
   */
  getActivities({ commit }, { babyId, date }) {
    const showDate = Vue.moment(date)
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
        paramsSerializer: function(params) {
          return qs.stringify(params, { arrayFormat: 'brackets' })
        }
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
  addActivity({ commit }, { babyId, activity }) {
    return this.$axios.post('activities', activity, {
      params: { baby_id: babyId }
    })
  },

  /**
   * View activity
   * @param {Object} param0
   * @param {Object} param1
   */
  viewActivity({ commit }, { activityId }) {
    return this.$axios.get(`activities/${activityId}`)
  },

  /**
   * Edit activity
   * @param {Object} param0
   * @param {Object} param1
   */
  editActivity({ commit }, { activityId, activity }) {
    return this.$axios.put(`activities/${activityId}`, activity)
  },

  /**
   * Delete activity
   * @param {Object} param0
   * @param {Object} param1
   */
  deleteActivity({ commit }, { activityId }) {
    return this.$axios.delete(`activities/${activityId}`)
  }
}
