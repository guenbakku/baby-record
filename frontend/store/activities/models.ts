import { CancelTokenSource } from 'axios'
import { BaseRecord, IndexResponse, ViewResponse } from '../models'

/* eslint-disable camelcase */
export type SubActivity<T extends {} = {}> = BaseRecord & {
  activity_id: string
} & T

export type SimpleSubActivity<SubActivity extends {}> = Omit<
  SubActivity,
  'created' | 'modified' | 'id' | 'activity_id'
>

export type BottleMilkSubActivity = SubActivity<{
  duration: number
  breast_volume: number
  fomular_volume: number
}>

export type BreastMilkSubActivity = SubActivity<{
  duration: number
}>

export type CustomSubActivity = SubActivity<{
  title: string
}>

export type DiaperSubActivity = SubActivity<{
  is_pee: boolean
  is_shit: boolean
}>

export type MeasurementSubActivity = SubActivity<{
  height?: number
  weight?: number
}>

export type PumpMilkSubActivity = SubActivity<{
  duration: number
  volume: number
}>

export type TemperatureSubActivity = SubActivity<{
  temperature: number
}>

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
  bottle_milk_activity?: BottleMilkSubActivity
  breast_milk_activity?: BreastMilkSubActivity
  custom_activity?: CustomSubActivity
  diaper_activity?: DiaperSubActivity
  measurement_activity?: MeasurementSubActivity
  pump_milk_activity?: PumpMilkSubActivity
  temperature_activity?: TemperatureSubActivity
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
