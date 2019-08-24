import Vue from 'vue'
import VueMoment from 'vue-moment'
import moment from 'moment-timezone'

moment.tz(moment.tz.guess())
moment.locale('vi')
Vue.use(VueMoment, {
  moment
})
