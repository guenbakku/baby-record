import { Baby as BaseBaby, SexId } from '~/store/babies/models'

export { Code } from '~/store/codes/models'
export { SexId } from '~/store/babies/models'
export type Baby = Omit<BaseBaby, 'created' | 'modified'>

/* eslint-disable camelcase */
export type BabyError = {
  birthday?: string
  name?: string
  sex_id?: string
  user_id?: string
}

export const initBaby = (): Baby => ({
  id: '',
  birthday: '',
  name: '',
  sex_id: SexId.boy,
  user_id: ''
})
/* eslint-enable camelcase */
