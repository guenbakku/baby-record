/**
 * Maps.
 * The order of items in this object is
 * the order of buttons in SpeedDial component.
 */
const MAPS = {
  breast_milk_activity: {
    title: 'Bú mẹ',
    component: 'BreastMilkForm'
  },
  bottle_milk_activity: {
    title: 'Bú bình',
    component: 'BottleMilkForm'
  },
  pump_milk_activity: {
    title: 'Vắt sữa',
    component: 'PumpMilkForm'
  },
  diaper_activity: {
    title: 'Thay tã',
    component: 'DiaperForm'
  },
  temperature_activity: {
    title: 'Nhiệt độ',
    component: 'TemperatureForm'
  },
  custom_activity: {
    title: 'Nhập tự do',
    component: 'CustomForm'
  }
}

/**
 * Return list of component object.
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
 * Return maps.
 *
 * @param Void
 * @return {Object}
 */
const getMaps = function() {
  return MAPS
}

export { loadComponents, getMaps }
