import Vue from 'vue'
import './plugins/axios'
import App from './App.vue'
import './registerServiceWorker'
import router from './router'
import store from './store'
import vuetify from './plugins/vuetify'
import VueYouTubeEmbed from 'vue-youtube-embed'
import "./plugins/vuetify-mask.js"
import db from '../src/services/localbase'
import VueParticles from 'vue-particles'
import "./plugins/vuetify-number.js"
import JsonExcel from "vue-json-excel";
import FormData from 'form-data'
Vue.component("downloadExcel", JsonExcel);
Vue.use(VueParticles)


//import VueSpinners from 'vue-spinners'

//Vue.use(VueSpinners)
Vue.config.productionTip = false
Vue.use(VueYouTubeEmbed)
new Vue({
  router,
  store,
  vuetify,
  db,
  FormData,
  render: h => h(App)
}).$mount('#app')
