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
            <v-list-item-subtitle> v1.0.0 </v-list-item-subtitle>
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
        <v-list-group
          v-show="verifyUserAccess()"
          v-for="item in items_adm"
          :key="item.title"
        >
          <template v-slot:activator>
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
          </template>
          <v-list-item
            v-for="child in item.items"
            :key="child.title"
            :to="child.to"
            class="item-nav"
          >
            <v-list-item-icon>
              <v-img
                v-if="child.img"
                width="10"
                :src="require('./assets/icons/' + child.img)"
              ></v-img>
              <v-icon v-else color="rgb(18,150,145)">{{ child.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>{{ child.title }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-group>
        <v-list-item class="item-nav" to="/about">
          <v-list-item-icon>
            <v-img
              width="10"
              :src="require('./assets/icons/about.png')"
            ></v-img>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>Sobre</v-list-item-title>
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
    ],
    items_adm: [
      {
        title: 'Gestão',
        icon: 'mdi-account-tie',
        img: 'adm.png',
        to: '',
        items: [
          {
            title: 'Usuários',
            icon: 'mdi-account-group',
            img: 'users.png',
            to: '/usuarios',
          },
          {
            title: 'Acessos',
            icon: 'mdi-eye',
            img: 'access-1.png',
            to: '/acessos',
          },
        ],
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
    verifyUserAccess() {
      if (this.$store.state.user.accesses) {
        return this.$store.state.user.accesses.accesses == 1;
      }
    },
  },
};
</script>
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
.v-tooltip__content {
  background-color: rgb(36, 33, 33) !important;
}
.font-quicksand {
  font-family: 'Quicksand', sans-serif;
}
.bold {
  font-weight: bold;
}
.second_font-bold {
  font-family: 'Varela Round', sans-serif;
  font-weight: bold;
}
.second_font {
  font-family: 'Varela Round', sans-serif;
}
.bolder {
  font-weight: bolder;
}
li::before {
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
.page-items-textfield input {
  text-align: center;
  font-weight: bold;
  transition: 0.3s;
}
.page-items-text {
  font-size: 13px;
  color: black;
  transition: 0.3s;
}
.title-card-dark {
  color: white;
  font-weight: bold;
  font-family: 'Quicksand', sans-serif;
  transition: 0.3s;
  background-color: rgb(24, 25, 26);
}
.subtitle-card-dark {
  color: rgb(143, 143, 143);
  font-weight: bold;
  font-family: 'Quicksand', sans-serif;
  transition: 0.3s;
  background-color: rgb(24, 25, 26);
}

.title-card {
  font-weight: bold;
  font-family: 'Quicksand', sans-serif;
  transition: 0.3s;
}
.subtitle-card {
  font-weight: bold;
  font-family: 'Quicksand', sans-serif;
  transition: 0.3s;
}
.hover-card:hover .subtitle-card {
  transition: 0.3s;
  color: black;
}
.hover-card:hover .subtitle-card-dark {
  color: white;
  transition: 0.3s;
}
.hover-card:hover .title-card,
.hover-card:hover .title-card-dark {
  transition: 0.3s;
  color: rgba(18, 210, 175);
}

.item-select-badge {
  font-family: 'Quicksand', sans-serif;
  font-size: 13px;
  padding-left: 5px;
}
.chip {
  max-width: 180px;
  min-width: 150px;
  max-height: 30px;
  flex: 1 1 auto;
  transition: 0.3s;
  background-size: 200% auto;
  align-items: center;
  display: inline-flex;
  justify-content: center;
  background-color: black;
  border-radius: 9999px;
  padding: 4px 8px;
}
.small-chip {
  margin-inline: 10px;
  max-width: 80px;
  min-width: 50px;
  max-height: 30px;
  flex: 1 1 auto;
  transition: 0.3s;
  background-size: 200% auto;
  align-items: center;
  display: inline-flex;
  justify-content: center;
  background-color: black;
  border-radius: 9999px;
  padding: 4px 8px;
}
.gradient-blue {
  background-image: linear-gradient(to right, #77caf3, #5b75dc, #77caf3);
}
.gradient-gray {
  background-image: linear-gradient(to right, #a0b7c0, #5f6e8b, #a0b7c0);
}
.gradient-orange {
  background-image: linear-gradient(to right, #fcc53b, #fa7618, #fcc53b);
}
.gradient-success {
  background-image: linear-gradient(to right, #49f87d, #40bfff, #49f87d);
}
.gradient-error {
  background-image: linear-gradient(to right, #ff648e, #ca0000, #ff648e);
}
.gradient-pink {
  background-image: linear-gradient(to right, #ff648e, #db6767, #ff64ed);
}
.chip:hover {
  background-position: right center; /* change the direction of the change here */
}
.small-chip:hover {
  background-position: right center; /* change the direction of the change here */
}
.chip__content {
  color: white;
  margin-right: 1px;
}
</style>