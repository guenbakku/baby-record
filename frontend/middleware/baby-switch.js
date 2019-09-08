/**
 * BabySwitch middleware
 * Determine if should show BabySwitch component in header.
 */
export default function({ store, route }) {
  const firstMatched = route.matched[0]
  if (!firstMatched) return

  let useBabySwitch = firstMatched.components.default.options
    ? firstMatched.components.default.options.useBabySwitch
    : firstMatched.components.default.useBabySwitch

  useBabySwitch = !!useBabySwitch
  store.commit('config/setUseBabySwitch', { value: useBabySwitch })
}
