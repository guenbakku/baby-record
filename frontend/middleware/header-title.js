const RULES = [
  {
    match: 'activities.*',
    title: 'Ghi chép'
  },
  {
    match: 'babies.*',
    title: 'Em bé'
  }
]

const selectHeaderTitle = function(routerName, rules) {
  for (const rule of rules) {
    const regex = RegExp(rule.match)
    if (regex.test(routerName)) {
      return rule.title
    }
  }

  return undefined
}

/**
 * Header title middleware
 */
export default function({ store, route }) {
  const headerTitle = selectHeaderTitle(route.name, RULES)
  if (headerTitle) {
    store.commit('config/setHeaderTitle', { value: headerTitle })
  }
}
