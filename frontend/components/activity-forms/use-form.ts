import { reactive } from '@vue/composition-api'

type PropToForm<P = any, F = any> = (props: P) => F
type FormToProp<F = any, P = any> = (form: F) => P

const isEmpty = (props: {}) => {
  return Object.keys(props).length === 0
}

export const useForm = <P = {}, F = {}>(
  initForm: F,
  props: P,
  propsToForm?: PropToForm<P, F>,
  formToProps?: FormToProp<F, P>
) => {
  const _propsToForm =
    propsToForm || ((props: P) => JSON.parse(JSON.stringify(props)) as F)

  const _formToProps =
    formToProps || ((form: F) => JSON.parse(JSON.stringify(form)) as P)

  const form = reactive<F>(isEmpty(props) ? initForm : _propsToForm(props))

  const getData = () => {
    return _formToProps(form as F)
  }

  return { form, getData }
}

export default useForm
