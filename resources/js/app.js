import Vue from 'vue'
import store from '~/store'
import axios from 'axios'
import moment from 'moment'

import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'
import helper from './plugins/helper'
import vmodal from 'vue-js-modal'

import '~/plugins'
import '~/components'
window.axios = axios;
window.helper = helper;
window.moment = moment;
Vue.use(vmodal)

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  i18n,
  store,
  router,
  ...App
})
