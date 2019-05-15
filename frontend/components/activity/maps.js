/**
 * Maps
 */
const MAPS = {
  bottle_milk_activity: {
    component: 'BottleMilkActivity',
    color: 'crimson'
  },
  breast_milk_activity: {
    component: 'BreastMilkActivity',
    color: 'teal'
  },
  custom_activity: {
    component: 'CustomActivity',
    color: 'deeppink'
  },
  diaper_activity: {
    component: 'DiaperActivity',
    color: 'blueviolet'
  },
  pump_milk_activity: {
    component: 'PumpMilkActivity',
    color: 'royalblue'
  },
  temperature_activity: {
    component: 'TemperatureActivity',
    color: 'firebrick'
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
