/**
 * List of forms
 */
const FORMS = {
  breastMilk: {
    title: 'Sữa mẹ',
    component: 'BreastMilkForm'
  },
  bottleMilk: {
    title: 'Sữa bình',
    component: 'BottleMilkForm'
  },
  pumpMilk: {
    title: 'Vắt sữa',
    component: 'BottleMilkForm'
  }
  // diaper: {
  //   title: 'Thay bỉm',
  //   component: 'DiaperForm'
  // },
  // temperature: {
  //   title: 'Nhiệt độ',
  //   component: 'TemperatureForm'
  // },
  // custom: {
  //   title: 'Nhập tự do',
  //   component: 'CustomForm'
  // }
}

/**
 * Return list of component object of forms.
 *
 * @param Void
 * @return {Object}
 */
const getFormComponents = function() {
  const components = {}
  for (const key in FORMS) {
    const componentName = FORMS[key].component
    const component = require(`./${componentName}`).default
    components[componentName] = component
  }
  return components
}

/**
 * Return list of forms.
 *
 * @param Void
 * @return {Object}
 */
const getFormMetas = function() {
  return FORMS
}

export { getFormComponents, getFormMetas }
