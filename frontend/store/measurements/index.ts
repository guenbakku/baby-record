import qs from 'qs'
import { MutationTree, ActionTree } from 'vuex'
import { RootState } from '../models'
import { State, ActivityIndexResponse } from './models'

export const state = (): State => ({
  rangeDate: { from: undefined, to: undefined },
  activities: []
})

export const mutations: MutationTree<State> = {
  setRangeDate(state, rangeDate: State['rangeDate']) {
    state.rangeDate = rangeDate
  },
  setActivities(
    state: State,
    { activities }: { activities: State['activities'] }
  ) {
    state.activities = activities
  }
}

export const actions: ActionTree<State, RootState> = {
  getActivities(
    { commit },
    { babyId, rangeDate }: { babyId: string; rangeDate?: State['rangeDate'] }
  ) {
    const filter: {
      from?: string
      to?: string
    } = {
      from: undefined,
      to: undefined
    }

    if (rangeDate && rangeDate.from) {
      filter.from = this.$moment(rangeDate.from)
        .hour(0)
        .minute(0)
        .second(0)
        .toISOString()
    }
    if (rangeDate && rangeDate.to) {
      filter.to = this.$moment(rangeDate.to)
        .hour(23)
        .minute(59)
        .second(59)
        .toISOString()
    }

    return this.$axios
      .get<ActivityIndexResponse>('/activities', {
        params: {
          baby_id: babyId,
          filter: {
            ...filter,
            activity_type_code: 'measurement_activity'
          },
          limit: 999,
          sort: 'started',
          direction: 'asc'
        },
        paramsSerializer(params) {
          return qs.stringify(params, { arrayFormat: 'brackets' })
        }
      })
      .then(function(res) {
        commit('setActivities', { activities: res.data.data })
        return res
      })
  }
}
