import Vue from 'vue'
import VueI18n from 'vue-i18n'
import vi from '../i18n/vi'

Vue.use(VueI18n)
const messages = { vi }

export default ({ app }) => {
  app.i18n = new VueI18n({
    locale: 'vi',
    messages
  })
}
