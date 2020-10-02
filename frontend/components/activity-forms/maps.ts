import { Component } from 'vue'

type Maps = {
  [k: string]: {
    title: string
    component: string
  }
}

type ComponentCollection = {
  [k: string]: Component
}

/**
 * Maps.
 * The order of items in this object is
 * the order of buttons in SpeedDial component.
 */
const MAPS: Maps = {
  breast_milk_activity: {
    title: 'Bú mẹ',
    component: 'BreastMilkForm'
  },
  bottle_milk_activity: {
    title: 'Bú bình',
    component: 'BottleMilkForm'
  },
  diaper_activity: {
    title: 'Thay tã',
    component: 'DiaperForm'
  },
  measurement_activity: {
    title: 'Số đo',
    component: 'MeasurementForm'
  },
  pump_milk_activity: {
    title: 'Vắt sữa',
    component: 'PumpMilkForm'
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
