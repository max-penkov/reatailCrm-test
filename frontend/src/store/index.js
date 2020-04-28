import Vue from "vue";
import Vuex from "vuex";
import ClientModule from "./Client"

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    client: ClientModule
  }
});
