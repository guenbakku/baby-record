import { reactive } from '@vue/composition-api'

type PropToForm<P = any, F = any> = (props: P) => F
type FormToProp<F = any, P = any> = (form: F) => P

const isEmpty = (props: {}) => {
  return Object.keys(props).length === 0
}

const useForm = <P extends {} = {}, F extends {} = {}>(
  initForm: F,
  props: P,
  propsToForm: PropToForm<P, F>,
  formToProps: FormToProp<F, P>
) => {
  const form = reactive<F>(isEmpty(props) ? initForm : propsToForm(props))

  const getData = () => {
    return formToProps(form as F)
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
