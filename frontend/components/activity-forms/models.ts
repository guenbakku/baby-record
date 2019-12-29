export type ActivityForm<T> = {
  started: string
  memo: string
} & T

export type ActivityError<T> = {
  started?: string
  memo?: string
} & T

export const declareProps = <D, E>() => ({
  data: {
    type: Object as () => D,
    default() {
      return {}
    }
  },
  errors: {
    type: Object as () => E,
    default: {}
  }
})
