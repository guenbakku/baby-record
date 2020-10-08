import { Activity } from '../activities/models'

export { Activity, ActivityIndexResponse } from '../activities/models'

export type State = {
  rangeDate: { from?: string; to?: string }
  activities: Activity[]
}

declare module '../models' {
  export interface RootState {
    measurements: State
  }
}
