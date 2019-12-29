export type State = {
  headerTitle: string | null
  useBabySwitch: boolean
  locale: string | null
}

declare module '../models' {
  export interface RootState {
    config: State
  }
}
