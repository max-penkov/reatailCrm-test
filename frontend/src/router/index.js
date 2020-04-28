import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/Home";

Vue.use(VueRouter);

export default new VueRouter({
  mode: 'history',
  routes: [
    {path: '/', name: 'home', component: Home},
    {path: '/clients', name: 'clients', component: () => import('../views/Client/Index')},
    // {path: '/users', component: () => import('../views/Users')},
    // {
    //   path: '/users/:id',
    //   name: 'User',
    //   component: () => import('../views/User'),
    // },
    // {path: '/channels', component: () => import('../views/Channels')},
    // {path: '/bases', component: () => import('../views/Base')},
    // {path: '/calls/statistic', name: 'stats', component: () => import('../views/Statistic')},
    // { path: "*", redirect: "/home" }
  ]
});