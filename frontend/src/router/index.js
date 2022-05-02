import Vue from 'vue'
import VueRouter from 'vue-router'
import LoginView from '../views/LoginView.vue'
import HomeView from '../views/HomeView.vue'
import TasksView from '../views/TasksView.vue'
import AboutView from '../views/AboutView.vue'
import LandingView from '../views/LandingView.vue'
import CommissionView from '../views/CommissionView.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/login',
    name: 'Login',
    component: LoginView
  },
  {
    path: '/',
    name: 'Home',
    component: HomeView
  },
  {
    path: '/tasks',
    name: 'Tasks',
    component: TasksView
  },
  {
    path: '/landing',
    name: 'Landing',
    component: LandingView
  },
  {
    path: '/comissao',
    name: 'Comissão',
    component: CommissionView
  },
  {
    path: '/about',
    name: 'About',
    component: AboutView
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
