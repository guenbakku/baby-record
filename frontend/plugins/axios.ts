import axios, { AxiosError, AxiosRequestConfig } from 'axios'
import { throttleAdapterEnhancer, cacheAdapterEnhancer } from 'axios-extensions'
import { Plugin } from '@nuxt/types'

declare module 'axios' {
  export interface AxiosRequestConfig {
    useCache?: boolean
  }
}

/**
 * Convert validated errors into the format that can be displayed in form
 * TODO: declare type
 * @param {Object} errors
 * @param {Object} parsed
 * @param {String} parentKey
 */
const parseValidatedErrors = function(
  errors: any,
  parsed: any = {},
  parentKey: string | undefined = undefined
) {
  for (const key in errors) {
    if (parentKey && typeof errors[key] !== 'object') {
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

const axiosPlugin: Plugin = ({ $axios, store, redirect, app }) => {
  if (!$axios.defaults.adapter) return

  /**
   * Change default adapter to axios-extension's one
   */
  const cacheAdapter = cacheAdapterEnhancer($axios.defaults.adapter, {
    enabledByDefault: false,
    cacheFlag: 'useCache'
  })
  const throttleAdapter = throttleAdapterEnhancer(cacheAdapter)
  $axios.defaults.adapter = throttleAdapter

  /**
   * Because environment variables parsed by dotenv-webpack
   * only be used after webpack bundling, so we must set them
   * in this plugin file instead of file `nuxt.config.js`
   */
  $axios.defaults.baseURL = process.env.API_BASE_URL

  /**
   * Add some headers.
   */
  $axios.setHeader('Accept', 'application/json')
  $axios.setHeader('Content-Type', 'application/json')
  $axios.setHeader('X-Timezone', app.$moment.tz.guess())

  $axios.onRequest((config: AxiosRequestConfig) => {
    // Add access token to request
    const token = store.state.auth.token
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }
  })

  /**
   * Configure interceptor on error
   */
  $axios.onError((error: AxiosError) => {
    if (axios.isCancel(error)) {
      // Do nothing
    } else if (!error.response) {
      store.commit('flash/error', {
        text: 'Could not send request to api server'
      })
    } else if (error.response.status >= 500) {
      store.commit('flash/error', {
        text: '500 Internal error. There is intenal error in api server.'
      })
    } else if (error.response.status === 403) {
      store.commit('flash/error', {
        text: "403 Forbidden. You don't have permission to execute this action."
      })
    } else if (error.response.status === 401) {
      store.commit('flash/error', {
        text: '401 Unauthorized. Authentication is required to continue.'
      })
      redirect('/logout')
    } else if (error.response.status === 422) {
      error.response.data.data.parsedErrors = parseValidatedErrors(
        error.response.data.data.errors
      )
    }
  })
}

export default axiosPlugin
