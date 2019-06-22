import moment from 'moment-timezone'

/**
 * Convert validated errors into the format that can be displayed in form
 * @param {Object} errors
 * @param {Object} parsed
 * @param {String} parentKey
 */
const parseValidatedErrors = function(
  errors,
  parsed = {},
  parentKey = undefined
) {
  for (const key in errors) {
    if (typeof errors[key] !== 'object') {
      if (!parsed[parentKey]) {
        parsed[parentKey] = []
      }
      parsed[parentKey].push(errors[key])
    } else if (parentKey) {
      parsed[parentKey] = parseValidatedErrors(
        errors[key],
        parsed[parentKey],
        key
      )
    } else {
      parsed = parseValidatedErrors(errors[key], parsed, key)
    }
  }
  return parsed
}

export default function({ $axios, store }) {
  /**
   * Because environment variables parsed by dotenv-webpack
   * only be used after webpack bundling, so we must set them
   * in this plugin file instead of file `nuxt.config.js`
   */
  $axios.defaults.baseURL = process.env.API_BASE_URL
  $axios.setHeader('Accept', 'application/json')
  $axios.setHeader('Content-Type', 'application/json')
  $axios.setHeader('X-Timezone', moment.tz.guess())

  // Add access token to request
  const token = store.getters['auth/token']
  if (token) {
    $axios.setHeader('Authorization', `Bearer ${token}`)
  }

  /**
   * Configure interceptor on error
   */
  $axios.onError(error => {
    if (!error.response) {
      store.commit('flash/error', {
        text: 'Could not send request to api server'
      })
    } else if (error.response.status >= 500) {
      store.commit('flash/error', {
        text: 'There is intenal error in api server'
      })
    } else if (error.response.status === 422) {
      error.response.data.data.parsedErrors = parseValidatedErrors(
        error.response.data.data.errors
      )
    }
  })
}
