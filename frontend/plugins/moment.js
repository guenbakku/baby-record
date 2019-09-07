import Vue from 'vue'
import VueMoment from 'vue-moment'
import moment from 'moment-timezone'

const userLang = navigator.language || navigator.userLanguage

moment.tz(moment.tz.guess())
moment.locale(userLang)
Vue.use(VueMoment, {
  moment
})
