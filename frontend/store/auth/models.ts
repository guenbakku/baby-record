import { BaseRecord, ApiResponse, ViewResponse } from '../models'

/* eslint-disable camelcase */
export type User = BaseRecord & {
  email: string
  name: string
  role: string
}

export type AuthResponse = ApiResponse<{ token: string }>
export type MeResponse = ViewResponse<User>

export type State = {
  token: string | null
  profile: User | {}
}

declare module '../models' {
  export interface RootState {
    auth: State
  }
}
