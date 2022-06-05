import Vue from 'vue'
import VueRouter from 'vue-router'
import LoginView from '../views/LoginView.vue'
import HomeView from '../views/HomeView.vue'
import DashboardView from '../views/DashboardView.vue'
import TasksView from '../views/TasksView.vue'
import UsersView from '../views/UsersView.vue'
import AccessView from '../views/AccessView.vue'
import AboutView from '../views/AboutView.vue'
import LandingView from '../views/LandingView.vue'
import CommissionView from '../views/CommissionView.vue'
import InvalidPageView from '../views/InvalidPageView.vue'

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
    path: '/dashboard',
    name: 'Dashboard',
    component: DashboardView
  },
  {
    path: '/checklist',
    name: 'Checklist',
    component: TasksView
  },
  {
    path: '/landing',
    name: 'Landing',
    component: LandingView
  },
  {
    path: '/comissoes',
    name: 'Comissões',
    component: CommissionView
  },
  {
    path: '/usuarios',
    name: 'Usuários',
    component: UsersView
  },
  {
    path: '/acessos',
    name: 'Acessos',
    component: AccessView
  },
  {
    path: '/about',
    name: 'Sobre',
    component: AboutView
  },
  {
    path: '/404',
    name: 'Página Inválida',
    component: InvalidPageView
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
