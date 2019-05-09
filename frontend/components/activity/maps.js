/**
 * Maps
 */
const MAPS = {
  bottle_milk_activity: {
    component: 'BottleMilkActivity'
  },
  breast_milk_activity: {
    component: 'BreastMilkActivity'
  },
  custom_activity: {
    component: 'CustomActivity'
  },
  diaper_activity: {
    component: 'DiaperActivity'
  },
  pump_milk_activity: {
    component: 'PumpMilkActivity'
  },
  temperature_activity: {
    component: 'TemperatureActivity'
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
