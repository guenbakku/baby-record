import { ViewResponse } from '../models'

export type State = {}

export type Code = {
  value: number
  code: string
  text: string
}

export type CodeViewResponse = ViewResponse<{ codes: Code[] }>

declare module '../models' {
  export interface RootState {
    codes: State
  }
}
