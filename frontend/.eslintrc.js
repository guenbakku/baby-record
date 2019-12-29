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
    'prettier'
  ],
  // add your custom rules here
  rules: {
  }
}
