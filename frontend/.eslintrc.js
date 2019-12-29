module.exports = {
  root: true,
  env: {
    browser: true,
    node: true
  },
  extends: [
    '@nuxtjs',
    '@nuxtjs/eslint-config-typescript',
    'plugin:nuxt/recommended',
    'plugin:prettier/recommended',
    'prettier',
    'prettier/vue',
    'prettier/@typescript-eslint'
  ],
  plugins: [
    'eslint-plugin-tsdoc',
    'prettier'
  ],
  // add your custom rules here
  rules: {
    "tsdoc/syntax": "warn"
  }
}
