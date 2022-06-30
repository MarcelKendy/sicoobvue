<template>
  <div>
    <v-card
      :dark="dark_theme"
      :class="dark_theme ? 'profile-card-dark' : ''"
      v-if="loading"
      height="100vh"
      class="pa-1 profile-card"
    >
      <v-skeleton-loader
        :dark="dark_theme"
        transition="scroll-y-transition"
        elevation="5"
        height="40vh"
        class="mx-auto"
        type="card"
      ></v-skeleton-loader>
    </v-card>
    <v-card
      :class="dark_theme ? 'profile-card-dark' : ''"
      v-else
      class="pt-1 px-1 pb-10 profile-card"
    >
      <div class="banner">
        <v-img
          src="@/assets/images/logosicoobcredisg.png"
          width="102"
          class="credisg-icon ma-3"
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
          <v-tooltip right color="success">
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
          <v-tooltip top :color="profile.active == 1 ? 'success' : 'error'">
            <template v-slot:activator="{ on, attrs }">
              <v-icon
                v-bind="attrs"
                v-on="on"
                :color="profile.active == 1 ? 'green' : 'red'"
                size="32"
                style="padding-bottom: 9px"
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
        <v-col cols="12">
          <v-hover v-slot:default="{ hover }">
            <v-card
              class="profile-introduction-card"
              outlined
              color="transparent"
              elevation="3"
            >
              <v-img
                src="@/assets/icons/sicoobicon.png"
                class="sicoob-icon"
                max-width="28"
              ></v-img>
              <span class="about-text" v-if="!activate_edit_profile">
                {{ profile.profile_about }} 
              </span>
              <v-text-field
                @keyup.enter="changeProfile"
                v-else
                placeholder='Pressione "enter" ou saia do campo para salvar'
                @click.stop
                @change="changeProfile"
                v-model="profile.profile_about"
                :loading="loading_profile_about"
                color="green"
                dark
                append-icon="mdi-pencil"
              >
              </v-text-field>
              <v-overlay absolute :value="hover && !activate_edit_profile" color="rgb(115,215,38)">
                <v-tooltip right>
                  <template v-slot:activator="{ attrs, on }">
                    <v-btn
                      fab
                      color="rgb(10,121,117)"
                      v-bind="attrs"
                      v-on="on"
                      @click="activate_edit_profile = true"
                    >
                      <v-icon>mdi-pencil</v-icon>
                    </v-btn>
                  </template>
                  <span>Editar "Sobre"</span>
                </v-tooltip>
              </v-overlay>
            </v-card>
          </v-hover>
        </v-col>
      </v-row>
      <v-row class="align-center px-10 mt-10">
        <v-col cols="12" md="6">
          <v-tooltip top v-model="hover_delay">
            <template v-slot:activator="{}">
              <v-card
                class="profile-info-card"
                outlined
                color="transparent"
                elevation="12"
              >
                <v-list class="transparent-list">
                  <v-hover
                    v-slot:default="{ hover }"
                    v-for="item in info_card_items"
                    :key="item.key"
                  >
                    <v-list-item
                      @mouseenter="activateTooltip()"
                      @click.stop.prevent="copyInfo(item.title)"
                      class="introduction-item"
                    >
                      <v-img
                        class="mr-5"
                        max-width="32"
                        :src="require('@/assets/icons/' + item.icon)"
                      ></v-img>

                      <v-list-item-content>
                        <span class="introduction-item-text">
                          {{ profile[item.data] }}
                        </span>
                      </v-list-item-content>
                      <v-slide-x-reverse-transition>
                        <div v-if="hover" class="mr-7">
                          <span class="introduction-item-title">
                            {{ item.title }}
                          </span>
                        </div>
                      </v-slide-x-reverse-transition>
                      <input
                        type="hidden"
                        :id="item.title"
                        :value="profile[item.data]"
                      />
                    </v-list-item>
                  </v-hover>
                </v-list>
              </v-card>
            </template>
            <span class="font-quicksand">Clique para copiar</span>
          </v-tooltip>
        </v-col>
        <v-col cols="12" md="6">
          <v-tooltip top v-model="hover_delay">
            <template v-slot:activator="{}">
              <v-card
                class="profile-info-card"
                outlined
                color="transparent"
                elevation="12"
              >
                <v-list class="transparent-list">
                  <v-hover
                    v-slot:default="{ hover }"
                    v-for="item in info_card_items"
                    :key="item.key"
                  >
                    <v-list-item
                      @mouseenter="activateTooltip()"
                      @click.stop.prevent="copyInfo(item.title)"
                      class="introduction-item"
                    >
                      <v-img
                        class="mr-5"
                        max-width="32"
                        :src="require('@/assets/icons/' + item.icon)"
                      ></v-img>

                      <v-list-item-content>
                        <span class="introduction-item-text">
                          {{ profile[item.data] }}
                        </span>
                      </v-list-item-content>
                      <v-slide-x-reverse-transition>
                        <div v-if="hover" class="mr-7">
                          <span class="introduction-item-title">
                            {{ item.title }}
                          </span>
                        </div>
                      </v-slide-x-reverse-transition>
                      <input
                        type="hidden"
                        :id="item.title"
                        :value="profile[item.data]"
                      />
                    </v-list-item>
                  </v-hover>
                </v-list>
              </v-card>
            </template>
            <span class="font-quicksand">Clique para copiar</span>
          </v-tooltip>
        </v-col>
      </v-row>
    </v-card>
    <v-snackbar
      v-model="snackbar_copy"
      timeout="2500"
      elevation="24"
      rounded="pill"
      color="success"
    >
      <v-icon class="pr-3" dark>mdi-check-circle</v-icon>
      <strong style="padding-left: 35px" class="white--text">{{
        this.snackbar_copy_message
      }}</strong>
    </v-snackbar>
  </div>
</template>

<script>
export default {
  name: 'ProfileComponent',
  data: () => ({
    loading: false,
    user_id: 0,
    unmasked_cpf: '',
    snackbar_copy: false,
    snackbar_copy_message: '',
    hover_delay: false,
    timeout_id: '',
    activate_edit_profile: false,
    loading_profile_about: false,
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
      profile_about: '',
    },
    info_card_items: [
      {
        key: 0,
        title: 'Função',
        data: 'role',
        icon: 'suitcase.png',
      },
      {
        key: 1,
        title: 'CPF',
        data: 'cpf',
        icon: 'id-card.png',
      },
      {
        key: 2,
        title: 'E-mail',
        data: 'email',
        icon: 'email.png',
      },
      {
        key: 3,
        title: 'Acesso',
        data: 'access',
        icon: 'access-1.png',
      },
    ],
  }),
  created() {
    this.loadProfile();
  },
  methods: {
    changeProfile() {
      this.loading_profile_about = true;
      this.$http
        .put(`edit_profile/${this.user_id}`, { profile_about: this.profile.profile_about })
        .then(() => {
          this.activate_edit_profile = this.loading_profile_about = false;
        });
    },
    copyInfo(info) {
      let element = document.querySelector('#' + info);
      element.setAttribute('type', 'text');
      element.select();

      try {
        let successful = document.execCommand('copy');
        this.snackbar_copy_message = successful
          ? info + ' copiado com sucesso!'
          : 'Não foi possível copiar ' + info;
        this.snackbar_copy = true;
      } catch (err) {
        alert(
          'Algum erro ocorreu. Certifique-se de usar o Google Chrome e contate o desenvolvedor.'
        );
      }

      /* unselect the range */
      element.setAttribute('type', 'hidden');
      window.getSelection().removeAllRanges();
    },
    loadProfile() {
      this.loading = true;
      this.user_id = this.$route.params.id;
      this.$http
        .post('get_profile', { user_id: this.user_id })
        .then((response) => {
          response.data.access = response.data.access.name;
          this.unmasked_cpf = response.data.cpf;
          response.data.cpf = response.data.cpf.replace(
            /(\d{3})(\d{3})(\d{3})(\d{2})/,
            function (
              regex,
              first_numbers,
              second_numbers,
              third_numbers,
              last_numbers
            ) {
              return (
                first_numbers +
                '.' +
                second_numbers +
                '.' +
                third_numbers +
                '-' +
                last_numbers
              );
            }
          );
          Object.assign(this.profile, response.data);
          this.loading = false;
        });
    },
    activateTooltip() {
      let _this = this;
      _this.hover_delay = true;
      clearTimeout(this.timeout_id);
      this.timeout_id = setTimeout(function () {
        _this.hover_delay = false;
      }, 1600);
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
  background-image: linear-gradient(
    to bottom right,
    rgba(0, 32, 68, 0.884),
    rgba(0, 73, 97, 0.801),
    rgba(28, 0, 59, 0.801)
  );
}

.profile-card-dark {
  color: white;
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
  width: 20px;
  height: 20px;
  border-radius: 100px;
}
.logged-badge:hover {
  box-shadow: rgb(105, 212, 72) 0px 0px 30px 2px;
}

.avatar-photo {
  position: absolute;
  bottom: -10vh;
  left: 10vh;
}

.credisg-icon {
  position: absolute;
  z-index: 2;
  right: 0px;
}

.sicoob-icon {
  border-radius: 0px !important;
  top: 0px;
  left: -7px;
  position: absolute;
}

.v-list-item--link:before {
  border-radius: 12px;
}

.profile-introduction-card {
  padding: 30px;
  color: white;
  border-radius: 30px;
  background-image: linear-gradient(
    to bottom right,
    rgba(255, 255, 255, 0.05),
    rgba(255, 255, 255, 0.05)
  );
}

.profile-info-card {
  padding: 20px;
  color: white;
  border-radius: 30px;
  background-image: linear-gradient(
    to bottom right,
    rgba(255, 255, 255, 0.05),
    rgba(255, 255, 255, 0.05)
  );
}

.transparent-list {
  background-color: rgba(255, 255, 255, 0);
}

.introduction-item {
  transition: 0.3s;
  border-radius: 12px;
  margin-bottom: 2px;
  background-color: rgba(255, 255, 255, 0);
}

.introduction-item:hover {
  transition: 0.5s;
  border-radius: 12px;
  margin-bottom: 2px;
  box-shadow: rgba(0, 0, 0, 0.788) 0px 22px 70px 4px;
}

.introduction-item-text {
  color: white;
  font-weight: bold;
}

.introduction-item-title {
  text-shadow: 1px 1px rgba(0, 0, 0, 0.87);
  color: white;
  font-weight: bold;
}

.about-text {
  font-size: 22px;
}
</style>
/*
background-image: linear-gradient(
    to bottom right,
    rgba(0, 73, 97, 0.89),
    rgba(0, 130, 108, 0.884),
    rgba(188, 255, 211, 0.904)
  );