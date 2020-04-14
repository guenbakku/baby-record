import { reactive } from '@vue/composition-api'

const isEmpty = (props: {}) => {
  return Object.keys(props).length === 0
}

const useForm = <P extends {} = {}, F extends {} = {}>(
  initForm: F,
  props: P
) => {
  const propsToForm = (props: P): F => JSON.parse(JSON.stringify(props))

  const form = reactive<F>(isEmpty(props) ? initForm : propsToForm(props))

  const getData = (): F => {
    return JSON.parse(JSON.stringify(form)) as F
  }

  const updateForm = (props: P) => {
    const data = propsToForm(props)
    Object.keys(form).forEach(key => {
      if (key in data) {
        ;(form as any)[key] = (data as any)[key]
      }
    })
  }

  return { form, getData, updateForm }
}

export default useForm
