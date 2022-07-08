import Vue from 'vue'
import VueRouter from 'vue-router'
import LoginView from '../views/LoginView.vue'
import HomeView from '../views/HomeView.vue'
import LandingView from '../views/LandingView.vue'
import DashboardView from '../views/DashboardView.vue'
import TasksView from '../views/TasksView.vue'
import UsersView from '../views/UsersView.vue'
import AccessView from '../views/AccessView.vue'
import UploadView from '../views/UploadView.vue'
import ProfileView from '../views/ProfileView.vue'
import AboutView from '../views/AboutView.vue'
import CommissionView from '../views/CommissionView.vue'
import InvalidPageView from '../views/InvalidPageView.vue'
import AccessDeniedView from '../views/AccessDeniedView.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/login',
    name: 'Login',
    component: LoginView
  },
  {
    path: '/',
    name: 'Landing',
    component: LandingView
  },
  {
    path: '/home',
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
    path: '/uploads',
    name: 'Uploads',
    component: UploadView
  },
  {
    path: '/perfil/:id',
    name: 'Perfil',
    component: ProfileView
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
  {
    path: '/505',
    name: 'Acesso Negado',
    component: AccessDeniedView
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  scrollBehavior() {
    // always scroll to top
    return { x: 0, y: 0 }
  },
  routes
})

export default router
