export type State = {
  headerTitle: string | null
  useBabySwitch: boolean
}

declare module '../models' {
  export interface RootState {
    config: State
  }
}
