import { BaseRecord, Date, IndexResponse, ViewResponse } from '../models'

/* eslint-disable camelcase */
export enum SexId {
  boy = 1,
  girl
}

export type Baby = BaseRecord & {
  birthday: Date
  name: string
  sex_id: SexId
  user_id: string
}

export type BabyIndexResponse = IndexResponse<Baby>
export type BabyViewResponse = ViewResponse<Baby>

export type State = {
  currentId: string | null
  babies: {
    [id: string]: Baby & { avatar: string }
  }
}

declare module '../models' {
  export interface RootState {
    babies: State
  }
}
