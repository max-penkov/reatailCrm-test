import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/Home";

Vue.use(VueRouter);

export default new VueRouter({
  mode: 'history',
  routes: [
    {path: '/', name: 'home', component: Home},
    {path: '/clients', name: 'clients', component: () => import('../views/Client/Index')},
    {
      path: '/clients/:id',
      name: 'client',
      component: () => import('../views/Client/Show'),
    },
  ]
});