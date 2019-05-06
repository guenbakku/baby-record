/**
 * Because environment variables parsed by dotenv-webpack
 * only be used after webpack bundling, so we must set them
 * in this plugin file instead of file `nuxt.config.js`
 */
export default function ({ $axios }) {
  $axios.defaults.baseURL = process.env.API_BASE_URL
  $axios.defaults.headers.common = {
    'Accept': 'application/json',
    'Content-Type': 'application/json'
  }
}
