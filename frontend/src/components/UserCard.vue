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
        :color="!dark_theme ? '#26c6da' : 'black'"
        class="mx-auto font-quicksand bold"
        max-width="300"
        :dark="dark_theme"
      >
        <v-list
          :class="
            dark_theme ? 'pa-0 user-card-header-dark' : 'pa-0 user-card-header'
          "
          dark
        >
          <v-img
            max-height="60px"
            src="../assets/images/backgrounds/bg1.png"
            gradient="to bottom left, rgba(173,12,227,.5), rgba(0,260,145,.6)"
          >
            <v-list-item>
              <v-list-item-avatar>
                <v-avatar size="42">
                  <v-img
                    v-if="user_photo"
                    alt="Foto"
                    :src="avatar_path(user_photo)"
                  ></v-img>
                  <v-img
                    v-else
                    :src="
                      require(user_gender == 1
                        ? './../assets/icons/man.png'
                        : './../assets/icons/woman.png')
                    "
                  ></v-img>
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
                  src="../assets/images/logos/sicoobicon.png"
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
              :color="dark_theme ? 'rgb(36, 0, 121)' : 'yellow lighten-1'"
              :dark="dark_theme"
              small
            >
              <span
                class="second_font-bold"
                :style="dark_theme ? 'color:white' : 'color:black'"
                >{{ dark_theme ? 'Dark' : 'Light' }}</span
              >
              <v-icon :style="dark_theme ? 'color:white' : 'color:black'" right>
                {{
                  dark_theme ? 'mdi-weather-night' : 'mdi-white-balance-sunny'
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
    theme: '',
  }),
  created() {
    /*if (!this.$store.state.user.length > 0) {
      db.collection('user')
        .limit(1)
        .get()
        .then((user) => {
          Object.assign(this.$store.state.user, user[0]);
        });
    }*/
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
      this.dark_theme ? (this.theme = 1) : (this.theme = 0);
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
    avatar_path(photo_path) {
      try {
        return require('../../../backend/storage/app/' + photo_path);
      } catch {
        return '';
      }
    },
  },

  computed: {
    user_name() {
      try {
        return this.$store.state.user.full_name;
      } catch (err) {
        return false;
      }
    },
    user_role() {
      try {
        return this.$store.state.user.role;
      } catch (err) {
        return false;
      }
    },
    user_photo() {
      try {
        return this.$store.state.user.photo;
      } catch (err) {
        return false;
      }
    },
    user_gender() {
      try {
        return this.$store.state.user.gender;
      } catch (err) {
        return false;
      }
    },
    dark_theme() {
      try {
        return this.$store.state.user.configs.theme == 0;
      } catch (err) {
        return false;
      }
    },
  },
};
</script>
<style scoped>
.user-card-header {
  border: solid;
  border-color: white;
  border-width: 2px;
}
.user-card-header-dark {
  border: solid;
  border-color: rgb(23, 0, 78);
  border-width: 2px;
}
</style>