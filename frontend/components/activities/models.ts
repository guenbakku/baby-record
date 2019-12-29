/* eslint-disable camelcase */
export type ActivityItem<T extends {}> = {
  id: string
  started: string
  memo: string
  activity_type: {
    code: string
    label: string
  }
} & T

export const initActivityItem = <T extends {}>(
  activity: T
): ActivityItem<T> => ({
  id: '',
  started: '',
  memo: '',
  activity_type: {
    code: '',
    label: ''
  },
  ...activity
})
