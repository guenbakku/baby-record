import { Middleware } from '@nuxt/types'

type Rule = {
  match: string
  title: string
}

const RULES: Rule[] = [
  {
    match: 'activities.*',
    title: 'Ghi chép'
  },
  {
    match: 'babies.*',
    title: 'Em bé'
  }
]

const selectHeaderTitle = function(
  routerName: string | undefined,
  rules: Rule[]
): string | undefined {
  if (routerName) {
    for (const rule of rules) {
      const regex = RegExp(rule.match)
      if (regex.test(routerName)) {
        return rule.title
      }
    }
  }

  return undefined
}

/**
 * Header title middleware
 */
const headerTitleMiddleware: Middleware = function({ store, route }) {
  const headerTitle = selectHeaderTitle(route.name, RULES)
  if (headerTitle) {
    store.commit('config/setHeaderTitle', { value: headerTitle })
  }
}

export default headerTitleMiddleware
