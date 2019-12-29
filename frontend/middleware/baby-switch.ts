import { Middleware } from '@nuxt/types'

type Component = {
  name: string
  [key: string]: any
}

/**
 * BabySwitch middleware
 * Determine if should show BabySwitch component in header.
 */
const babySwitchMiddleware: Middleware = ({ store, route }) => {
  const firstMatched = route.matched[0]
  if (!firstMatched) return

  // TODO: remove this hacking (fix typescript type's problem)
  const component = <Component>firstMatched.components.default
  let useBabySwitch = component.options
    ? component.options.useBabySwitch
    : component.useBabySwitch

  useBabySwitch = !!useBabySwitch
  store.commit('config/setUseBabySwitch', { value: useBabySwitch })
}

export default babySwitchMiddleware
