import { RootState } from '../models'

export enum Type {
  error = 'error',
  success = 'success'
}

export enum Color {
  error = 'error',
  success = 'success'
}

export type State = {
  text: string | null
  type: Type | null
  show: boolean
}

declare module '../models' {
  export interface RootState {
    flash: State
  }
}
