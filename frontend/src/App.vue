<template>
  <v-app id="inspire" v-if="login_check">
   <v-navigation-drawer v-model="drawer" v-if="$route.name != 'Login'" app>
     <v-img height="236px" src="./assets/images/bg1.png" gradient="to bottom left, rgba(173,12,227,.5), rgba(0,260,145,.6)" dark class="pt-5 text-center">
      <v-avatar
        size="80px">
                  <img
                    alt="Avatar"
                    src="./assets/images/logo.png"
                    
                  >
        </v-avatar>
      <v-list-item>
        
        <v-list-item-content style="padding-top:40px">
          <v-list-item-title style="font-family: 'Quicksand', sans-serif; font-size:24px">
            <strong>Sicoob Credisg</strong>
          </v-list-item-title>
          <v-list-item-subtitle  style="font-family: 'Patrick Hand', cursive;font-size:18px">
            Software
          </v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>
     </v-img>
    <v-divider></v-divider>

      <v-list
        dense
        nav
      >
        <v-list-item
          v-for="item in items"
          :key="item.title"
          :to="item.to"
          link
        >
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>



    <v-app-bar v-if="$route.name != 'Login'"
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

      
      <strong style="padding-left: 20px;padding-top: 3px;font-family: 'Quicksand', sans-serif;font-size: 24px;">Bem Vindo</strong>
      
      

      <v-spacer></v-spacer>

      
      <user-card/>
    </v-app-bar>
  

    <v-main>
      <router-view></router-view>
    </v-main>
    <footer-component v-if="$route.name != 'Login'"></footer-component>
  </v-app>
</template>

<script>
import db from '../src/services/localbase'
import FooterComponent from './components/FooterComponent.vue'
import UserCard from './components/util/UserCard.vue'
  export default {
  components: { FooterComponent, UserCard },
    data: () => 
    ({ 
      drawer: false,
      items: [
          { title: 'Home', icon: 'mdi-view-dashboard', to: '/'},
          { title: 'Checklist', icon: 'mdi-view-list', to: '/tasks'},
          { title: 'Comissão', icon: 'mdi-view-list', to: '/comissao'},
          { title: 'Sobre', icon: 'mdi-help', to: '/about' }
      ],
      login_check: false,
      store_ready: false
    }),
    watch: {
      $route: {
        immediate: true,
        handler(to) {
          document.title = 'Sicoob Credisg - ' + to.name || 'Sicoob Credisg';
        }
      },
      
    },
    mounted () {
      this.verifyLoggedUser()
    },
    methods: {
       verifyLoggedUser () {
         db.collection('user').limit(1).get().then(user => {
          if (!user.length && this.$route.name != 'Login') {
            this.$router.push('/login')
          } 
          this.$store.state.user = {}
          Object.assign(this.$store.state.user, (user[0]))
          this.login_check = true
        })  
       }
    },
  }
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Asap+Condensed:ital@1&family=Bebas+Neue&family=Concert+One&family=Courgette&family=Dancing+Script:wght@500&family=Fredoka+One&family=Pacifico&family=Parisienne&family=Patrick+Hand&family=Permanent+Marker&family=Press+Start+2P&family=Quicksand&family=Satisfy&family=Shadows+Into+Light&family=Yanone+Kaffeesatz:wght@600&display=swap');
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