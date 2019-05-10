import moment from 'moment-timezone'

export default function({ $axios, store, app }) {
  /**
   * Because environment variables parsed by dotenv-webpack
   * only be used after webpack bundling, so we must set them
   * in this plugin file instead of file `nuxt.config.js`
   */
  $axios.defaults.baseURL = process.env.API_BASE_URL
  $axios.setHeader('Accept', 'application/json')
  $axios.setHeader('Content-Type', 'application/json')
  $axios.setHeader('X-Timezone', moment.tz.guess())

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
    }
  })
}
