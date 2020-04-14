import { Location } from 'vue-router'

export const getTypeStyle = (color: string) => {
  return {
    backgroundColor: color
  }
}

export const getEditRoute = (activityId: string): Location => {
  return {
    name: 'activities-edit-id',
    params: {
      id: activityId
    }
  }
}
