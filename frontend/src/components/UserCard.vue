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

      <v-card
        color="#26c6da"
        class="mx-auto font-quicksand bold"
        max-width="300"
        :dark="theme == 0"
      >
        <v-list class="pa-0" style="border: solid; border-color: white; border-width: 2px" dark>
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
            :disabled="item.title == 'Tema' ? loading_theme : false"
          >
            <v-list-item-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-action>
            <v-list-item-title>{{ item.title }}</v-list-item-title>

            <v-btn
              v-if="item.button"
              rounded
              :loading="loading_theme"
              elevation="9"
              :color="theme == 0 ? 'rgb(36, 0, 121)' : 'yellow lighten-1'"
              :dark="theme == 0"
              small
            >
              <span
                class="second_font-bold"
                :style="theme == 0 ? 'color:white' : 'color:black'"
                >{{ theme == 0 ? 'Dark' : 'Light' }}</span
              >
              <v-icon :style="theme == 0 ? 'color:white' : 'color:black'" right>
                {{
                  theme == 0 ? 'mdi-weather-night' : 'mdi-white-balance-sunny'
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
      { title: 'Tema', icon: 'mdi-palette', button: true },
      { title: 'Sair', icon: 'mdi-logout' },
    ],
    confirmation_logout: false,
    menu: false,
    loading_theme: false,
    name: '',
    edit_profile: false,
    cpf: '',
    user_info: {},
    theme: 0,
  }),
  created() {
    console.log(this.$store.state.user);
    this.theme = this.$store.state.user.configs.theme;
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
        case 'Tema':
          this.changeTheme();
          break;
        default:
          break;
      }
    },
    changeTheme() {
      this.loading_theme = true;
      this.theme == 1 ? (this.theme = 0) : (this.theme = 1);
      this.$store.state.user.configs.theme = this.theme;
      this.$store.dispatch('configs', this.$store.state.user);
      this.$http
        .put(`edit_user/${this.$store.state.user.id}`, {
          configs: 'change',
          theme: this.theme,
        })
        .then(() => {
          this.loading_theme = false;
        });
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
