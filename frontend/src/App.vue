<template>
  <v-app id="inspire" v-if="login_check">
    <v-navigation-drawer
      v-model="drawer"
      v-if="$route.name != 'Login' && $route.name != 'Landing'"
      app
      :dark="dark_theme"
    >
      <v-img
        height="216px"
        :src="
          require(dark_theme
            ? './assets/images/circuitsbg2.png'
            : './assets/images/circuitsbg2.png')
        "
        :gradient="
          dark_theme
            ? 'to bottom left, rgba(3,0,24,.9), rgba(143,20,174,.4)'
            : 'to bottom left, rgba(23,152,185,.9), rgba(25,135,80,.5), rgba(100,255,45,.3)'
        "
        dark
        class="pt-5 text-center"
      >
        <v-avatar size="80px">
          <v-img
            alt="Avatar"
            :src="
              state_user.photo
                ? avatar_path(state_user.photo)
                : require(state_user.gender == 1
                    ? './assets/images/man.png'
                    : './assets/images/woman.png')
            "
          ></v-img>
        </v-avatar>
        <v-list-item>
          <v-list-item-content style="padding-top: 40px">
            <v-list-item-title
              style="font-family: 'Quicksand', sans-serif; font-size: 24px"
            >
              <strong>{{ $store.state.software.name }}</strong>
            </v-list-item-title>
            <v-list-item-subtitle>
              {{ $store.state.software.version }}
            </v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
      </v-img>

      <v-divider color="black"></v-divider>

      <v-list dense nav active-class="bg-active" v-if="state_user_access">
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
          v-show="verifyScreenAccess('adm')"
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
            v-show="verifyScreenAccess(child.title)"
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
      v-if="$route.name != 'Login' && $route.name != 'Landing'"
      shrink-on-scroll
      app
      :color="dark_theme ? 'rgba(8,140,105,.9)' : 'rgba(18,200,175,.9)'"
      dark
      src="./assets/images/main-banner.png"
      fade-img-on-scroll
      scroll-threshold="200"
    >
      <template v-slot:img="{ props }">
        <v-img
          v-bind="props"
          :gradient="
            dark_theme
              ? 'to bottom right, rgba(143,22,167,.4), rgba(40,90,85,.1)'
              : 'to bottom right, rgba(83,112,227,.4), rgba(80,200,145,.1)'
          "
        ></v-img>
      </template>

      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

      <v-img
        class="ma-2"
        max-width="32"
        src="./assets/icons/sicoobicon.png"
      ></v-img>
      <strong style="font-size: 24px" class="font-quicksand mx-2 mt-1">{{
        state_user.gender == 1
          ? 'Bem-Vindo, ' + state_user.name
          : 'Bem-Vinda, ' + state_user.name
      }}</strong>

      <v-spacer></v-spacer>

      <user-card />
    </v-app-bar>

    <v-main
      :class="this.dark_theme ? 'main-dark' : 'main-light'"
      v-if="$route.name != 'Login'"
    >
      <bread-crumb-component
        v-if="$route.name != 'Login' && $route.name != 'Landing'"
        :activeRoute="this.$route.name"
      ></bread-crumb-component>
      <router-view></router-view>
    </v-main>
    <v-main class="font-quicksand" v-else>
      <router-view></router-view>
    </v-main>
    <footer-component v-if="$route.name != 'Login'"></footer-component>
  </v-app>
</template>

<script>
import db from '../src/services/localbase';
import FooterComponent from './components/FooterComponent.vue';
import UserCard from './components/UserCard.vue';
import BreadCrumbComponent from './components/Util/BreadCrumbComponent.vue';
export default {
  components: { FooterComponent, UserCard, BreadCrumbComponent },
  data: () => ({
    drawer: false,
    items: [
      /*{
        title: 'Home',
        icon: 'mdi-view-dashboard',
        img: 'landing-page.png',
        to: '/home',
      },*/
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
        if (to.name == 'Dashboard') {
          this.verifyLoggedUser();
        }
      },
    },
    state_user_access: function () {
      if (this.state_user_access) {
        let verify_screen_access = this.verifyScreenAccess(this.$route.name);
        if (verify_screen_access == 404) {
          this.$route.name == 'Página Inválida'
            ? ''
            : this.$router.push('/404');
        } else {
          this.$route.name !== 'Home' && !verify_screen_access
            ? this.$router.push('/505')
            : '';
        }
      }
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
          if (
            !user.length &&
            this.$route.name != 'Login' &&
            this.$route.name != 'Landing'
          ) {
            this.$router.push('/login');
          }
          this.$store.state.user = {};
          Object.assign(this.$store.state.user, user[0]);
          this.login_check = true;
        });
    },
    verifyScreenAccess(screen) {
      if (this.$store.state.user.accesses) {
        switch (screen) {
          case 'Acessos':
            return this.$store.state.user.accesses.accesses == 1;
          case 'Usuários':
            return this.$store.state.user.accesses.users == 1;
          case 'adm':
            return (
              this.$store.state.user.accesses.users == 1 ||
              this.$store.state.user.accesses.accesses == 1
            );
          case 'Comissões':
            return true;
          case 'Dashboard':
            return true;
          case 'Home':
            return true;
          case 'Landing':
            return true;
          case 'Checklist':
            return true;
          case 'Sobre':
            return true;
          case 'Login':
            return true;
          default:
            return 404;
        }
      } else {
        return false;
      }
    },
    avatar_path(photo_path) {
      try {
        return require('../../backend/storage/app/' + photo_path);
      } catch {
        return '';
      }
    },
  },
  computed: {
    dark_theme() {
      try {
        return this.$store.state.user.configs.theme == 0;
      } catch (err) {
        return false;
      }
    },
    state_user_access() {
      try {
        return this.$store.state.user.accesses;
      } catch (err) {
        return false;
      }
    },
    state_user() {
      try {
        return this.$store.state.user;
      } catch (err) {
        return false;
      }
    },
  },
};
</script>
<style scoped>
.main-dark {
  font-family: 'Quicksand', sans-serif;
  background-color: #191a1b;
}
.main-light {
  font-family: 'Quicksand', sans-serif;
  background-color: #eeeeee;
}
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
.bg-black {
  background-color: rgb(211, 210, 210) !important;
  color: #27282b !important;
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
.data-table-dark {
  background-color: rgb(30, 30, 31) !important;
  font-weight: bold;
  transition: 0.8s;
}
.data-table-light {
  background-color: rgba(255, 255, 255, 0.8) !important;
  font-weight: bold;
  transition: 0.8s;
}
.title-card-dark {
  color: white;
  font-weight: bold;
  font-family: 'Quicksand', sans-serif;
  transition: 0.3s;
  background-color: rgb(30, 30, 31);
}
.subtitle-card-dark {
  color: rgb(143, 143, 143);
  font-weight: bold;
  font-family: 'Quicksand', sans-serif;
  transition: 0.3s;
  background-color: rgb(30, 30, 31);
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
.list-item {
  transition: 0.3s;
  box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px,
    rgba(0, 0, 0, 0.3) 0px 5px 7px -3px, rgba(0, 0, 0, 0.2) 0px -1px 0px inset;
}
.list-item:hover {
  box-shadow: rgba(0, 0, 0, 0.4) 0px 12px 14px,
    rgba(0, 0, 0, 0.3) 10px 15px 17px -5px,
    rgba(0, 0, 0, 0.7) 4px -1px 0px inset;
}
.list-item-dark {
  background-color: rgba(82, 82, 82, 0.4);
  transition: 0.3s;
  box-shadow: rgb(0, 0, 0) 0px 2px 4px,
    rgba(116, 116, 116, 0.3) 0px 5px 7px -3px,
    rgba(92, 92, 92, 0.2) 0px 0px 0px inset;
}
.list-item-dark:hover {
  box-shadow: rgba(0, 0, 0, 0.4) 0px 12px 14px, rgb(0, 0, 0) 10px 15px 17px -5px,
    rgb(255, 255, 255) 4px 0px 0px inset;
}
.expansion-item {
  transition: 0.3s;
  box-shadow: rgba(0, 0, 0, 0.4) 0px 0px 0px 0px,
    rgba(0, 0, 0, 0.3) 0px 1px 3px -3px, rgba(0, 0, 0, 0.2) 0px 0px 0px inset;
}
.expansion-item:hover {
  box-shadow: rgba(0, 0, 0, 0.4) 0px 0px 0px 0px,
    rgba(0, 0, 0, 0.3) 3px 3px 15px -3px, rgba(0, 0, 0, 0.7) 4px 0px 0px inset;
}
.expansion-item-dark {
  background-color: rgba(83, 83, 83, 0.4) !important;
  transition: 0.3s;
  box-shadow: rgb(0, 0, 0) 0px 0px 0px 0px,
    rgba(0, 0, 0, 0.459) 3px 5px 5px -3px, rgb(0, 0, 0) 0px 0px inset;
}
.expansion-item-dark:hover {
  box-shadow: rgba(0, 0, 0, 0.4) 0px 0px 0px 1px, rgb(0, 0, 0) 2px 0px 0px 0px,
    rgba(15, 62, 163, 0.74) 4px 0px inset;
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