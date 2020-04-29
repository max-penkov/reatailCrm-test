import Vue from "vue";
import App from "./App";
import router from "./router";
import store from './store'
import BootstrapVue from 'bootstrap-vue';
import Widget from './components/Widget/Widget';
import Paginate from 'vuejs-paginate';
import moment from 'moment';

Vue.use(BootstrapVue);
Vue.component('Widget', Widget);
Vue.component('paginate', Paginate);
Vue.prototype.$moment = moment;

window.events = new Vue();
window.flash = function (message, level = 'success') {
  window.events.$emit('flash', { message, level });
};


new Vue({
  render: h => h(App),
  router,
  store
}).$mount("#app");