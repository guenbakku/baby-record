import { CancelTokenSource } from 'axios'
import { BaseRecord, IndexResponse, ViewResponse } from '../models'

/* eslint-disable camelcase */
export type BaseActivity = BaseRecord & {
  activity_id: string
}

export type BottleMilkActivity = BaseActivity & {
  duration: number
  breast_volume: number
  fomular_volume: number
}

export type BreastMilkActivity = BaseActivity & {
  duration: number
}

export type CustomActivity = BaseActivity & {
  title: string
}

export type DiaperActivity = BaseActivity & {
  is_pee: boolean
  is_shit: boolean
}

export type PumpMilkActivity = BaseActivity & {
  duration: number
  volume: number
}

export type TemperatureActivity = BaseActivity & {
  temperature: number
}

export type ActivityType = BaseRecord & {
  code: string
  label: string
  sort_no: number
}

export enum ActivityTypeId {
  BottleMilk = 1,
  BreastMilk,
  PumpMilk,
  Diaper,
  Temperature,
  Custom
}

export type Activity = BaseRecord & {
  activity_type_id: ActivityTypeId
  baby_id: string
  started: string
  memo: string
  activity_type: ActivityType
  bottle_milk_activity?: BottleMilkActivity
  breast_milk_activity?: BreastMilkActivity
  custom_activity?: CustomActivity
  diaper_activity?: DiaperActivity
  pump_milk_activity?: PumpMilkActivity
  temperature_activity?: TemperatureActivity
}

export type ActivityIndexResponse = IndexResponse<Activity[]>
export type ActivityViewResponse = ViewResponse<Activity>

export type State = {
  date: string | null
  activities: Activity[]
  cancelTokenSources: {
    [k: string]: CancelTokenSource
  }
}

declare module '../models' {
  export interface RootState {
    activities: State
  }
}
