<template>
  <v-app id="inspire" v-if="login_check">
    <v-navigation-drawer v-model="drawer" v-if="$route.name != 'Login'" app>
      <v-img
        height="216px"
        src="./assets/images/bg1.png"
        gradient="to bottom left, rgba(173,12,227,.5), rgba(0,260,145,.6)"
        dark
        class="pt-5 text-center"
      >
        <v-avatar size="80px">
          <img alt="Avatar" src="./assets/images/logo.png" />
        </v-avatar>
        <v-list-item>
          <v-list-item-content style="padding-top: 40px">
            <v-list-item-title
              style="font-family: 'Quicksand', sans-serif; font-size: 24px"
            >
              <strong>Sicoob Credisg</strong>
            </v-list-item-title>
            <v-list-item-subtitle
              style="font-family: 'Patrick Hand', cursive; font-size: 18px"
            >
              Software
            </v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
      </v-img>

      <v-divider color="black"></v-divider>

      <v-list dense nav active-class="bg-active">
        <v-list-item
          v-for="item in items"
          :key="item.title"
          :to="item.to"
          class="item-nav"
        >
          <v-list-item-icon>
            <v-img
              v-if="item.img"
              width="10"
              :src="require('./assets/icons/' + item.img)"
            ></v-img>
            <v-icon v-else color="rgb(18,150,145)">{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar
      v-if="$route.name != 'Login'"
      shrink-on-scroll
      app
      color="rgba(18,210,175,.9)"
      dark
      src="./assets/images/credisgbuilding.png"
      fade-img-on-scroll
      scroll-threshold="200"
    >
      <template v-slot:img="{ props }">
        <v-img
          v-bind="props"
          gradient="to bottom left, rgba(173,12,227,.5), rgba(0,260,145,.6)"
        ></v-img>
      </template>

      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

      <strong
        style="
          padding-left: 20px;
          padding-top: 3px;
          font-family: 'Quicksand', sans-serif;
          font-size: 24px;
        "
        >Bem Vindo</strong
      >

      <v-spacer></v-spacer>

      <user-card />
    </v-app-bar>

    <v-main style="font-family: 'Quicksand', sans-serif">
      <bread-crumb-component
        :activeRoute="this.$route.name"
      ></bread-crumb-component>
      <router-view></router-view>
    </v-main>
    <footer-component v-if="$route.name != 'Login'"></footer-component>
  </v-app>
</template>

<script>
import db from '../src/services/localbase';
import FooterComponent from './components/FooterComponent.vue';
import UserCard from './components/UserCard.vue';
import BreadCrumbComponent from './components/BreadCrumbComponent.vue';
export default {
  components: { FooterComponent, UserCard, BreadCrumbComponent },
  data: () => ({
    drawer: false,
    items: [
      {
        title: 'Home',
        icon: 'mdi-view-dashboard',
        img: 'landing-page.png',
        to: '/',
      },
      {
        title: 'Dashboard',
        icon: 'mdi-view-dashboard',
        img: 'dashboard-4.png',
        to: '/dashboard',
      },
      {
        title: 'Checklist',
        icon: 'mdi-list-status',
        img: 'checklist.png',
        to: '/checklist',
      },
      {
        title: 'Comissões',
        icon: 'mdi-view-list',
        img: 'commission.png',
        to: '/comissoes',
      },
      {
        title: 'Usuários',
        icon: 'mdi-account-group',
        img: 'users.png',
        to: '/usuarios',
      },
      {
        title: 'Acessos',
        icon: 'mdi-eye',
        img: 'accesses1.png',
        to: '/acessos',
      },
      {
        title: 'Sobre',
        icon: 'mdi-help',
        img: 'about.png',
        to: '/about',
      },
    ],
    login_check: false,
    store_ready: false,
  }),
  watch: {
    $route: {
      immediate: true,
      handler(to) {
        document.title = 'Sicoob Credisg - ' + to.name || 'Sicoob Credisg';
      },
    },
  },
  mounted() {
    this.verifyLoggedUser();
  },
  methods: {
    verifyLoggedUser() {
      db.collection('user')
        .limit(1)
        .get()
        .then((user) => {
          if (!user.length && this.$route.name != 'Login') {
            this.$router.push('/login');
          }
          this.$store.state.user = {};
          Object.assign(this.$store.state.user, user[0]);
          this.login_check = true;
        });
    },
  },
};
</script>
<style>
.font-quicksand {
  font-family: 'Quicksand', sans-serif;
}
.bold {
  font-weight: bold;
}
.bolder {
  font-weight: bolder;
}
</style>
<style scoped>
.item-nav {
  transition: 0.3s;
}
.item-nav:hover {
  color: white !important;
  background-size: 200% auto;
  background-image: linear-gradient(to right, #49def8, #49f8cf, #a449f8);
  background-position: right center;
}

.v-list-item--active {
  background-size: 200% auto;
  background-image: linear-gradient(to right, #49def8, #49f8cf, #a449f8);
  background-position: right center;
  color: white !important;
}
/*
font-family: 'Asap Condensed', sans-serif;
font-family: 'Bebas Neue', cursive;
font-family: 'Concert One', cursive;
font-family: 'Courgette', cursive;
font-family: 'Dancing Script', cursive;
font-family: 'Fredoka One', cursive;
font-family: 'Pacifico', cursive;
font-family: 'Parisienne', cursive;
font-family: 'Patrick Hand', cursive;
font-family: 'Permanent Marker', cursive;
font-family: 'Press Start 2P', cursive;
font-family: 'Quicksand', sans-serif;
font-family: 'Satisfy', cursive;
font-family: 'Shadows Into Light', cursive;
font-family: 'Yanone Kaffeesatz', sans-serif;
*/
</style>
<style>
li::before{
   opacity: 0;
}
.hover-card {
  transition: 0.3s !important;
  box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px,
    rgba(60, 64, 67, 0.15) 0px 2px 6px 2px !important;
  transition: box-shadow 0.3s !important;
}
.hover-card:hover {
  box-shadow: rgba(0, 0, 0, 0.3) 0px 19px 38px,
    rgba(0, 0, 0, 0.22) 0px 15px 12px !important;
}
</style>