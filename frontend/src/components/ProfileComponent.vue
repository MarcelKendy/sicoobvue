<template>
  <div>
    <v-card
      :dark="dark_theme"
      :class="dark_theme ? 'profile-card-dark' : ''"
      v-if="loading"
      height="100vh"
      class="pa-1 profile-card"
    >
      <v-skeleton-loader :dark="dark_theme" transition="scroll-y-transition" elevation="5" height="40vh" class="mx-auto" type="card"></v-skeleton-loader>
    </v-card>
    <v-card
      :dark="dark_theme"
      :class="dark_theme ? 'profile-card-dark' : ''"
      v-else
      height="100vh"
      class="pa-1 profile-card"
    >
      <div class="banner">
        <v-img
          src="@/assets/images/logosicoobcredisg.png"
          width="102"
          class="sicoob-icon ma-3"
          style="position: absolute; z-index: 2; right: 0px"
        ></v-img>
        <v-img
          class="cover-photo"
          src="@/assets/images/wallpapers/nature1.jpg"
          height="40vh"
        ></v-img>
        <div style="position: relative">
          <v-avatar class="avatar-photo rounded-gradient-border" size="25vh">
            <v-img v-if="profile.photo" :src="avatar_path(profile.photo)">
            </v-img>
            <v-img
              v-else
              :src="
                require(profile.gender == 1
                  ? './../assets/images/man.png'
                  : './../assets/images/woman.png')
              "
            ></v-img>
          </v-avatar>
          <v-tooltip top>
            <template v-slot:activator="{ on, attrs }">
              <v-icon
                v-if="profile.logged"
                large
                v-bind="attrs"
                v-on="on"
                class="logged-badge"
                right
                color="green"
                >mdi-check-decagram</v-icon
              >
            </template>
            <span class="font-quicksand bold">ONLINE</span>
          </v-tooltip>
        </div>

        <span style="display: inline" class="profile-name"
          >{{ profile.full_name }}
          <v-tooltip top>
            <template v-slot:activator="{ on, attrs }">
              <v-icon
                v-bind="attrs"
                v-on="on"
                :color="profile.active == 1 ? 'green' : 'red'"
                large
                style="padding-left: 20px; padding-bottom: 9px"
                >{{
                  profile.active == 1
                    ? 'mdi-account-check'
                    : 'mdi-account-cancel'
                }}</v-icon
              >
            </template>
            <span class="font-quicksand bold">{{
              profile.active == 1 ? 'Conta Ativa' : 'Conta Desativada'
            }}</span>
          </v-tooltip>
        </span>
      </div>
      <v-row class="align-center px-10 mt-10">
        <v-col cols="12" md="6">
         <v-card height="200" class="introduction-card">
          <v-card-title><strong>Sobre</strong></v-card-title>
         </v-card>
        </v-col>
        <v-col cols="12" md="6">
          <v-card>
            <v-card-title>
              <strong>Informações Pessoais:</strong>
            </v-card-title>
            <v-card-text class="profile-info-card" :class="dark_theme ? 'profile-info-card-dark' : ''">
              <span
                >Email: <span>{{ profile.email }}</span></span
              >
              <br />
              <span
                >Função: <span>{{ profile.role }}</span></span
              >
              <br />
              <span>CPF: <span>{{ profile.cpf }}</span></span>
              <br />
              <span>Acesso: <span>{{ profile.access }}</span></span>
              <br />
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-card>
  </div>
</template>

<script>
export default {
  name: 'ProfileComponent',
  data: () => ({
    loading: false,
    user_id: 0,
    profile: {
      full_name: '',
      cpf: '',
      email: '',
      gender: '',
      role: '',
      active: '',
      access: '',
      photo: '',
      logged: '',
    },
  }),
  created() {
    this.loadProfile();
  },
  methods: {
    loadProfile() {
      this.loading = true;
      this.user_id = this.$route.params.id;
      this.$http
        .post('get_profile', { user_id: this.user_id })
        .then((response) => {
          response.data.access = response.data.access.name;
          Object.assign(this.profile, response.data);
          this.loading = false;
        });
    },
    avatar_path(photo_path) {
      return require('../../../backend/storage/app/' + photo_path);
    },
  },
  computed: {
    dark_theme() {
      return this.$store.state.user.configs.theme == 0;
    },
  },
};
</script>

<style scoped>

.background-image {
  filter: brightness(70%);
  position: relative;
  overflow: hidden;
  width: 100%;
  height: 100%;
  position: absolute;
  top: 0;
  left: 0;
  background: no-repeat center center;
  background-size: cover;
  transform: scale(1.1);
}

.profile-card {
  background-color: rgb(255, 255, 255);
  box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset,
    rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset,
    rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px,
    rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px,
    rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px !important;
}

.profile-card-dark {
  color: white;
  background-color: rgba(0, 0, 0, 0.32) !important;
}

.profile-info-card {
  font-weight: bold !important;
  color: black !important;
}

.profile-info-card-dark {
  color: rgb(255, 255, 255) !important;
}

.profile-name {
  font-weight: bold;
  color: white;
  text-shadow: 1px 1px black;
  position: absolute;
  font-size: 4vh;
  bottom: 2vh;
  left: 40vh;
}

.cover-photo {
  border-radius: 5px;
}

.rounded-gradient-border {
  width: 300px;
  height: 80px;
  border: double 3px transparent;
  border-radius: 100%;
  background-image: linear-gradient(rgb(9, 52, 95), rgb(56, 195, 32)),
    radial-gradient(
      circle at top left,
      rgb(107, 205, 54),
      rgb(46, 115, 168),
      rgb(229, 255, 0)
    );
  background-origin: border-box;
  background-clip: content-box, border-box;
}

.banner {
  margin-bottom: 100px;
  position: relative;
}

.logged-badge {
  position: absolute;
  top: -11vh;
  left: 30vh;
}

.avatar-photo {
  position: absolute;
  bottom: -10vh;
  left: 10vh;
}

.sicoob-icon {
  position: absolute;
  z-index: 2;
  right: 0px;
}

.introduction-card {
  color: white;
  border-radius: 30px;
  background-image: linear-gradient(to bottom right, rgba(0, 73, 97, 0.432), rgba(0, 130, 108, 0.534), rgba(188, 255, 212, 0.4));
}

</style>