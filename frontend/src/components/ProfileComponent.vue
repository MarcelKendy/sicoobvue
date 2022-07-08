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
        type="card-avatar"
      ></v-skeleton-loader>
      <v-skeleton-loader
        :dark="dark_theme"
        transition="scroll-y-transition"
        elevation="5"
        height="15vh"
        class="mx-auto"
        type="list-item-two-line"
      ></v-skeleton-loader>
      <br />
      <v-row>
        <v-col cols="12" md="6">
          <v-skeleton-loader
            :dark="dark_theme"
            transition="scroll-y-transition"
            elevation="5"
            height="20vh"
            class="mx-auto"
            type="list-item-avatar-three-line"
          ></v-skeleton-loader>
        </v-col>
        <v-col cols="12" md="6">
          <v-skeleton-loader
            :dark="dark_theme"
            transition="scroll-y-transition"
            elevation="5"
            height="20vh"
            class="mx-auto"
            type="list-item-avatar-three-line"
          ></v-skeleton-loader>
        </v-col>
      </v-row>
    </v-card>
    <v-card
      :class="dark_theme ? 'profile-card-dark' : ''"
      v-else
      class="pt-1 px-1 pb-10 profile-card"
    >
      <v-img
        src="@/assets/images/backgrounds/transparentbg.png"
        class="background-card-image"
      >
        <div class="banner">
          <v-img
            src="@/assets/images/logos/logosicoobcredisg.png"
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
              <span>ONLINE</span>
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
              <span>{{
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
                  counter="600"
                  maxlength="600"
                  @keyup.enter="changeProfile"
                  v-else
                  placeholder='Pressione "enter" ou saia do campo para salvar'
                  @click.stop
                  @change="changeProfile"
                  v-model="profile.profile_about"
                  :loading="loading_profile_about"
                  color="yellow"
                  dark
                  append-icon="mdi-pencil"
                >
                </v-text-field>
                <v-overlay
                  absolute
                  :value="hover && !activate_edit_profile"
                  color="rgba(60, 150, 99, 0.9)"
                >
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
                    <span class="yellow--text" style="font-weight: 500"
                      >Deixe uma introdução sobre você!</span
                    >
                  </v-tooltip>
                </v-overlay>
              </v-card>
            </v-hover>
          </v-col>
        </v-row>
        <v-tooltip top v-model="hover_delay">
          <template v-slot:activator="{}">
            <v-row class="align-center px-10 mt-10">
              <v-col cols="12" md="6">
                <v-card
                  class="profile-info-card-1"
                  shaped
                  color="transparent"
                  elevation="12"
                >
                  <v-list class="transparent-list">
                    <v-hover
                      v-slot:default="{ hover }"
                      v-for="item in info_cards_items[0]"
                      :key="item.key"
                    >
                      <v-list-item
                        @click.stop.prevent="copyInfo(item.data, item.title)"
                        class="introduction-item"
                      >
                        <v-img
                          class="mr-5"
                          max-width="32"
                          :src="require('@/assets/icons/' + item.icon)"
                        ></v-img>

                        <v-list-item-content>
                          <span class="introduction-item-text">
                            {{
                              profile[item.data]
                                ? item.mask
                                  ? item.mask(profile[item.data])
                                  : profile[item.data]
                                : 'Dado não fornecido'
                            }}
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
                          :id="item.data"
                          :value="
                            profile[item.data]
                              ? profile[item.data]
                              : 'Dado não fornecido'
                          "
                        />
                      </v-list-item>
                    </v-hover>
                  </v-list>
                </v-card>
              </v-col>
              <v-col cols="12" md="6">
                <v-card
                  class="profile-info-card-2"
                  shaped
                  color="transparent"
                  elevation="12"
                >
                  <v-list class="transparent-list">
                    <v-hover
                      v-slot:default="{ hover }"
                      v-for="item in info_cards_items[1]"
                      :key="item.key"
                    >
                      <v-list-item
                        @click.stop.prevent="copyInfo(item.data, item.title)"
                        class="introduction-item"
                      >
                        <v-img
                          class="mr-5"
                          max-width="32"
                          :src="require('@/assets/icons/' + item.icon)"
                        ></v-img>

                        <v-list-item-content>
                          <span class="introduction-item-text">
                            {{
                              profile[item.data]
                                ? profile[item.data]
                                : 'Dado não fornecido'
                            }}
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
                          :id="item.data"
                          :value="
                            profile[item.data]
                              ? profile[item.data]
                              : 'Dado não fornecido'
                          "
                        />
                      </v-list-item>
                    </v-hover>
                  </v-list>
                </v-card>
              </v-col>
            </v-row>
          </template>
          <span class="orange--text"
            >Clique em uma informação abaixo para copiá-la</span
          >
        </v-tooltip>
      </v-img>
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
    file_excel: null,
    loading: false,
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
      department: '',
      team: '',
      active: '',
      access: '',
      photo: '',
      logged: '',
      profile_about: '',
      address: '',
      phone: '',
      phone_corporation: '',
    },
    info_cards_items: [
      [
        {
          key: 0,
          title: 'Cargo',
          data: 'role',
          icon: 'suitcase.png',
        },
        {
          key: 1,
          title: 'Setor',
          data: 'department',
          icon: 'department.png',
        },
        {
          key: 2,
          title: 'Equipe',
          data: 'team',
          icon: 'team.png',
        },
        {
          key: 3,
          title: 'Agência',
          data: 'agency',
          mask: function (value) {
            return value == 1 ? 'Matriz' : 'PA-01';
          },
          icon: 'building.png',
        },
        {
          key: 4,
          title: 'Acesso',
          data: 'access',
          icon: 'access-1.png',
        },
      ],
      [
        {
          key: 0,
          title: 'Endereço',
          data: 'address',
          icon: 'house.png',
        },
        {
          key: 1,
          title: 'E-mail',
          data: 'email',
          icon: 'email.png',
        },
        {
          key: 2,
          title: 'Ramal',
          data: 'phone_corporation',
          icon: 'phone_corporation.png',
        },
        {
          key: 3,
          title: 'Contato Pessoal',
          data: 'phone',
          icon: 'phone.png',
        },
        {
          key: 4,
          title: 'CPF',
          data: 'cpf',
          icon: 'id-card.png',
        },
      ],
    ],
  }),
  created() {
    this.loadProfile();
  },
  methods: {
    changeProfile() {
      this.loading_profile_about = true;
      this.$http
        .put(`edit_profile/${this.user_id}`, {
          profile_about: this.profile.profile_about,
        })
        .then(() => {
          this.activate_edit_profile = this.loading_profile_about = false;
        });
    },
    copyInfo(info, title) {
      let element = document.querySelector('#' + info);
      element.setAttribute('type', 'text');
      element.select();

      try {
        let successful = document.execCommand('copy');
        this.snackbar_copy_message = successful
          ? '"' + title + '"' + ' copiado com sucesso!'
          : 'Não foi possível copiar ' + title;
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
      this.$http
        .post('get_profile', { user_id: this.user_id })
        .then((response) => {
          this.formatData(response.data);
          this.loading = false;
          this.activateTooltip(4);
        });
    },
    formatData(data) {
      data.access = data.access.name;
      this.unmasked_cpf = data.cpf;
      data.cpf = data.cpf.replace(
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
      let role = data.role;
      data.role = role.name;
      data.department = role.department.name;
      data.team = role.department.team;
      Object.assign(this.profile, data);
    },
    activateTooltip(delay) {
      let _this = this;
      _this.hover_delay = true;
      clearTimeout(this.timeout_id);
      this.timeout_id = setTimeout(function () {
        _this.hover_delay = false;
      }, delay * 1000);
    },
    avatar_path(photo_path) {
      return require('../../../backend/storage/app/' + photo_path);
    },
  },
  computed: {
    dark_theme() {
      return this.$store.state.user.configs.theme == 0;
    },
    user_id() {
      return this.$route.params.id;
    },
    state_user() {
      return this.$store.state.user;
    },
  },
  watch: {
    user_id: function () {
      if (!this.loading) {
        this.loadProfile();
      }
    },
    state_user: function () {
      if (this.user_id == this.state_user.id) {
        Object.assign(this.profile, this.state_user);
        this.profile.cpf = this.profile.cpf.replace(
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
      }
    },
  },
};
</script>

<style scoped>
.background-card-image {
  background: no-repeat center center;
  background-size: cover;
  overflow: hidden;
}
.background-image {
  filter: brightness(70%);
  overflow: hidden;
  position: absolute;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  background: no-repeat center center;
  background-size: cover;
  transform: scale(1.1);
}

.profile-card {
  box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset,
    rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset,
    rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px,
    rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px,
    rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px !important;
  background-image: linear-gradient(
    to bottom right,
    rgba(0, 40, 56, 0.945),
    rgba(0, 73, 107, 0.884),
    rgba(42, 0, 109, 0.788)
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
  box-shadow: rgb(69, 216, 25) 0px 0px 30px 4px;
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
    to top left,
    rgba(0, 167, 173, 0.877),
    rgba(68, 212, 152, 0.623),
    rgba(130, 216, 79, 0.664)
  );
}

.profile-info-card-1 {
  padding: 20px;
  color: white;
  border-radius: 30px;
  background-image: linear-gradient(
    to bottom right,
    rgba(0, 136, 141, 0.658),
    rgba(86, 62, 192, 0.651)
  );
}
.profile-info-card-2 {
  padding: 20px;
  color: white;
  border-radius: 30px;
  background-image: linear-gradient(
    to bottom left,
    rgba(0, 136, 141, 0.658),
    rgba(86, 62, 192, 0.651)
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