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
        <v-btn color="white" dark v-bind="attrs" v-on="on" icon>
          <v-icon>mdi-account-cog-outline</v-icon>
        </v-btn>
      </template>

      <v-card color="#26c6da" dark class="mx-auto title-class" max-width="300">
        <v-list>
          <v-img
            max-height="60px"
            src="../assets/images/bg1.png"
            gradient="to bottom left, rgba(173,12,227,.5), rgba(0,260,145,.6)"
          >
            <v-list-item>
              <v-list-item-avatar>
                <v-avatar size="36px">
                  <img v-if="false" alt="Foto" src="" />
                  <v-icon v-else>mdi-account</v-icon>
                </v-avatar>
              </v-list-item-avatar>

              <v-list-item-content>
                <v-list-item-title :title="user_name">{{
                  user_name
                }}</v-list-item-title>
                <v-list-item-subtitle>{{ user_role }}</v-list-item-subtitle>
              </v-list-item-content>

              <v-list-item-action>
                <v-img
                  max-width="35px"
                  alt="Sicoob"
                  src="../assets/images/sicoobicon.png"
                ></v-img>
              </v-list-item-action>
            </v-list-item>
          </v-img>
        </v-list>

        <v-divider></v-divider>

        <v-list>
          <v-list-item
            v-for="item in items"
            :key="item.title"
            @click="actions(item.title)"
          >
            <v-list-item-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-action>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
            
              <v-btn
              v-if="item.button"
                rounded
                elevation="9"
                :color="theme == 1 ? 'rgb(36, 0, 121)' : 'yellow lighten-1'"
                :dark="theme == 1"
                @click="theme == 1 ? (theme = 0) : (theme = 1)"
                small
              >
                <span class="second_font-bold" :style="theme == 1 ? 'color:white' : 'color:black'">{{
                  theme == 1 ? 'Dark' : 'Light'
                }}</span>
                <v-icon :style="theme == 1 ? 'color:white' : 'color:black'" right>
                  {{
                    theme == 1 ? 'mdi-weather-night' : 'mdi-white-balance-sunny'
                  }}
                </v-icon>
              </v-btn>
         
          </v-list-item>
        </v-list>
      </v-card>
    </v-menu>
    <modal-logout
      :activate="confirmation_logout"
      @logout="logout"
      @closeLogoutModal="closeModalLogout"
    />
    <modal-edit
      :open="edit_profile"
      :user="user_info"
      @closeModal="closeModalEdit"
    ></modal-edit>
  </div>
</template>

<script>
import db from '../../src/services/localbase';
import ModalLogout from './Modals/ModalLogout.vue';
import ModalEdit from './Modals/ModalEditProfile.vue';
export default {
  props: ['user'],
  components: { ModalLogout, ModalEdit },
  name: 'UserCard',

  data: () => ({
    items: [
      { title: 'Informações Pessoais', icon: 'mdi-account-edit' },
      { title: 'Tema', icon: 'mdi-palette', button: true},
      { title: 'Sair', icon: 'mdi-logout' },
    ],
    confirmation_logout: false,
    menu: false,
    name: '',
    edit_profile: false,
    cpf: '',
    user_info: {},
    theme: 0,
  }),
  watch: {
    theme: function () {
      this.loading_theme = true;
      this.$store.state.user.configs.theme = this.theme
      this.$store
        .dispatch('configs', this.$store.state.user)
        .then((this.loading_theme = false));
    },
  },
  methods: {
    actions(item) {
      switch (item) {
        case 'Sair':
          this.openModalLogout();
          break;
        case 'Informações Pessoais':
          this.openModalEdit();
          break;
        default:
          break;
      }
    },
    logout() {
      db.collection('user')
        .doc('logged_token')
        .delete()
        .then(() => {
          this.$router.push('/login');
          this.$store.state.user = {};
        });
    },
    openModalEdit() {
      this.user_info = this.$store.state.user;
      this.edit_profile = true;
    },
    closeModalEdit() {
      this.edit_profile = false;
    },
    openModalLogout() {
      this.confirmation_logout = true;
    },
    closeModalLogout() {
      this.confirmation_logout = false;
    },
  },

  computed: {
    user_name() {
      return this.$store.state.user.full_name;
    },
    user_role() {
      return this.$store.state.user.role;
    },
  },
};
</script>
<style scoped>
.title-class {
  font-family: 'Quicksand', sans-serif;
  font-weight: bolder;
}
</style>