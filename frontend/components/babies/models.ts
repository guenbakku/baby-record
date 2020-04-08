import { Baby as BaseBaby, SexId } from '~/store/babies/models'

export type Baby = Omit<BaseBaby, 'created' | 'modified'>

export const initBaby = (): Baby => ({
  id: '',
  birthday: '',
  name: '',
  sex_id: SexId.boy,
  user_id: ''
})
