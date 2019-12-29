import VuetifyLoaderPlugin from 'vuetify-loader/lib/plugin'
import pkg from './package.json'

const BASE_PATH = '/frontend'

export default {
  mode: 'spa',

  /**
   * Fix hot reloading issue when develop by using docker for windows
   */
  watchers: {
    webpack: {
      poll: true
    }
  },

  /*
   ** Headers of the page
   */
  head: {
    title: pkg.title,
    meta: [
      { charset: 'utf-8' },
      { name: 'robots', content: 'noindex' },
      { name: 'copyright', content: 'guenbakku' },
      { name: 'keywords', content: 'baby record, baby, record' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: pkg.description },
      {
        hid: 'mobile-web-app-capable',
        name: 'mobile-web-app-capable',
        content: 'false'
      }
    ],
    link: [
      {
        rel: 'icon',
        type: 'image/x-icon',
        href: `${BASE_PATH}/favicon.ico`
      },
      {
        rel: 'shortcut icon',
        type: 'image/png',
        href: `${BASE_PATH}/shortcut-icon.png`
      },
      {
        rel: 'apple-touch-icon',
        type: 'image/png',
        href: `${BASE_PATH}/shortcut-icon.png`
      },
      {
        rel: 'stylesheet',
        href:
          'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons'
      }
    ]
  },

  router: {
    mode: 'hash',
    base: BASE_PATH,
    middleware: ['auth', 'baby', 'header-title', 'baby-switch']
  },

  generate: {
    dir: '../backend/webroot/frontend'
  },

  /*
   ** Customize the progress-bar color
   */
  loading: { color: '#fff', continuous: true },

  /*
   ** Global CSS
   */
  css: ['~/assets/style/app.styl'],

  /*
   ** Plugins to load before mounting the App
   */
  plugins: [
    '@/plugins/es-shim',
    '@/plugins/object-path',
    '@/plugins/moment',
    '@/plugins/vue-i18n',
    '@/plugins/axios',
    '@/plugins/change-case',
    '@/plugins/vuetify'
  ],

  /*
   ** Nuxt.js modules
   */
  modules: [
    // Doc: https://axios.nuxtjs.org/usage
    '@nuxtjs/dotenv',
    '@nuxtjs/axios',
    '@nuxtjs/pwa'
  ],

  /*
   ** Axios module configuration
   */
  axios: {
    // See https://github.com/nuxt-community/axios-module#options
  },

  buildModules: [
    [
      '@nuxt/typescript-build',
      {
        typeCheck: true,
        ignoreNotFoundWarnings: true
      }
    ]
  ],

  /*
   ** Build configuration
   */
  build: {
    transpile: ['vuetify/lib'],
    plugins: [new VuetifyLoaderPlugin()],
    loaders: {
      stylus: {
        import: ['~assets/style/variables.styl']
      }
    },
    /*
     ** You can extend webpack config here
     */
    extend(config, ctx) {
      // Run ESLint on save
      if (ctx.isDev && ctx.isClient) {
        config.module.rules.push({
          enforce: 'pre',
          test: /\.(js|vue)$/,
          loader: 'eslint-loader',
          exclude: /(node_modules)/
        })

        config.module.rules.push({
          resourceQuery: /blockType=i18n/,
          type: 'javascript/auto',
          loader: '@kazupon/vue-i18n-loader'
        })
      }
    }
  }
}
