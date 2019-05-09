/**
 * List of forms
 */
const MAPS = {
  breast_milk_activity: {
    title: 'Sữa mẹ',
    component: 'BreastMilkForm'
  },
  bottle_milk_activity: {
    title: 'Sữa bình',
    component: 'BottleMilkForm'
  }
  // pumpMilk: {
  //   title: 'Vắt sữa',
  //   component: 'BottleMilkForm'
  // },
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
const loadComponents = function() {
  const components = {}
  for (const key in MAPS) {
    const componentName = MAPS[key].component
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
const getMaps = function() {
  return MAPS
}

export { loadComponents, getMaps }
