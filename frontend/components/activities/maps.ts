import { Component } from 'vue'

type Maps = {
  [k: string]: {
    component: string
    color: string
  }
}

type ComponentCollection = {
  [k: string]: Component
}

/**
 * Maps
 */
const MAPS: Maps = {
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
  measurement_activity: {
    component: 'MeasurementActivity',
    color: 'slateblue'
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
 */
const loadComponents = function() {
  const components: ComponentCollection = {}
  for (const key in MAPS) {
    const componentName = MAPS[key].component
    const component = require(`./${componentName}`).default as Component
    components[componentName] = component
  }
  return components
}

/**
 * Return maps.
 */
const getMaps = function() {
  return MAPS
}

export { loadComponents, getMaps }
