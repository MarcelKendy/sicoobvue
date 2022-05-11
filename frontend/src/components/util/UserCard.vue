<template>
<div>
 <v-menu
      
      transition="slide-y-transition"
      :close-on-content-click="false"
      offset-x
      bottom
      left
    >
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          color="white"
          dark
          v-bind="attrs"
          v-on="on"
          icon
        >
          <v-icon>mdi-account-cog-outline</v-icon>       
        </v-btn>
      </template>
     
       <v-card 
        color="#26c6da"
        dark
        class="mx-auto"
        max-width="300"
        >
        <v-list>
          <v-list-item>
            <v-list-item-avatar>
              <v-avatar
                  size="36px"
                >
                  <img
                    v-if="false"
                    alt="Foto"
                    src=""
                  >
                  <v-icon
                    v-else
                  >mdi-account</v-icon>
                </v-avatar>
            </v-list-item-avatar>

            <v-list-item-content>
              <v-list-item-title :title="user_name">{{user_name}}</v-list-item-title>
              <v-list-item-subtitle>{{user_cpf}}</v-list-item-subtitle>
            </v-list-item-content>

            <v-list-item-action>
    
                
                  <v-img
                    max-width="35px"
                    alt="Sicoob"
                    src="../../assets/images/sicoobicon.png"
                  ></v-img>
                  
               
            </v-list-item-action>
          </v-list-item>
        </v-list>

        <v-divider></v-divider>

        <v-list>
          <v-list-item v-for="item in items" :key="item.title">
            <v-list-item-action>
              <v-btn @click="openModalLogout" icon><v-icon>mdi-logout</v-icon></v-btn>
            </v-list-item-action>
            <v-list-item-title class="title-class">{{item.title}}</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-card>

      
      
      
         </v-menu>
    <modal-logout :activate="confirmation_logout" @logout="logout" @closeLogoutModal="closeModalLogout"/>
</div>
</template>

<script>
import db from '../../../src/services/localbase'
import ModalLogout from './../Modals/ModalLogout.vue'
  export default {
    props:['user'],
    components: { ModalLogout },
    name: 'UserCard',

    data: () => ({
      items: [{title: 'Log Out'}],
      confirmation_logout: false,
      menu: false,
      name: '',
      cpf: ''
    }),
    methods: {
      logout () {
        db.collection('user').doc('logged_token').delete().then(() => {
          this.$router.push('/login')
          this.$store.state.user = {}
        })
      },
      getStateUser () {
        
      },
      openModalLogout () {
        this.confirmation_logout = true
      },
      closeModalLogout () {
        this.confirmation_logout = false
      }      
    },
    
    computed: {
      user_name () {
        return this.$store.state.user.full_name 
      },
      user_cpf() {
        return this.$store.state.user.cpf 
      },
    },
    
  }
</script>
<style scoped>
.title-class {
  font-family: 'Quicksand', sans-serif;
  font-weight: bolder; 
   
}
</style>