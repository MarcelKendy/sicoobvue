<template>
  <div>
    <v-card
      class="hover-card"
      shaped
      elevation="7"
      :loading="loading"
      outlined
      :dark="dark_theme"
    >
      <v-card-title class="bold title-card">
        Usuários do Sistema

        <v-img
          class="mx-2"
          style="display: inline-block"
          src="@/assets/icons/sicoobicon.png"
          max-width="20"
        ></v-img>
      </v-card-title>
      <v-card-subtitle>
        <span :class="dark_theme ? 'bold subtitle-card-dark' : 'subtitle-card'"
          >Controle de usuários</span
        >
      </v-card-subtitle>
      <v-card-text>
        <img
          v-if="loading"
          width="70"
          class="loading-gif my-10"
          src="../assets/images/loading.gif"
        />
        <v-list three-line v-for="(item, index) in items" :key="index">
          <v-list-item
            :key="index + 0.1"
            :class="dark_theme ? 'list-item-dark' : 'list-item'"
          >
            <v-tooltip top color="green darken-3">
              <template v-slot:activator="{ attrs, on }">
                <v-list-item-avatar
                  class="mt-6"
                  size="48"
                  v-bind="attrs"
                  v-on="on"
                >
                  <v-img v-if="item.photo" :src="avatar_path(item.photo)"
                    ><v-btn
                      :color="item.active ? 'success' : 'error'"
                      width="48"
                      height="48"
                      icon
                      :to="'/perfil/' + item.id"
                    ></v-btn
                  ></v-img>

                  <v-img
                    v-else
                    :src="
                      require(`./../assets/icons/${
                        item.gender == 1 ? 'man.png' : 'woman.png'
                      }`)
                    "
                    ><v-btn
                      :color="item.active ? 'success' : 'error'"
                      width="48"
                      height="48"
                      icon
                      :to="'/perfil/' + item.id"
                    ></v-btn
                  ></v-img>
                </v-list-item-avatar>
              </template>
              <div>
                <span class="tooltip-text">Perfil</span>
                <v-icon small dark class="tooltip-icon-right"
                  >mdi-account-arrow-right</v-icon
                >
                <v-img
                  class="tooltip-icon-sicoob"
                  src="@/assets/icons/sicoobicon.png"
                  width="13"
                ></v-img>
              </div>
            </v-tooltip>

            <v-list-item-content class="bold">
              <span>{{ item.full_name }}</span>
              <v-list-item-subtitle>{{
                item.cpf.replace(
                  /(\d{3})(\d{3})(\d{3})(\d{2})/,
                  function (
                    regex,
                    first_digits,
                    second_digits,
                    third_digits,
                    last_digits
                  ) {
                    return (
                      first_digits +
                      '.' +
                      second_digits +
                      '.' +
                      third_digits +
                      '-' +
                      last_digits
                    );
                  }
                )
              }}</v-list-item-subtitle>
            </v-list-item-content>
            <v-list-item-content class="bold">
              <span>{{ item.role.name }}</span>
            </v-list-item-content>
            <v-list-item-content class="bold">
              <v-form ref="form_access" v-model="valid_access" lazy-validation>
                <v-row align="center" justify="center">
                  <v-col cols="2">
                    <v-img
                      max-width="35px"
                      src="./../assets/icons/access-1.png"
                    ></v-img>
                  </v-col>
                  <v-col cols="10">
                    <v-autocomplete
                      class="pr-9"
                      label="Acesso"
                      :color="color"
                      append-icon="mdi-key"
                      :rules="requiredAccessRule"
                      placeholder="Informe o acesso"
                      v-model="item.access_id"
                      :items="accesses"
                      :loading="loading_access_computed(item.id)"
                      auto-select-first
                      @change="
                        loading_access[item.id] = true;
                        changeAccess(item.id, item.access_id);
                      "
                      item-text="name"
                      item-value="id"
                    >
                      <template v-slot:no-data>
                        <div class="px-4">
                          <span
                            style="
                              font-family: 'Quicksand', sans-serif;
                              font-weight: bold;
                            "
                            >Nenhum acesso encontrado</span
                          >
                          <v-tooltip id="tooltip" top color="green darken-3">
                            <template v-slot:activator="{ on, attrs }">
                              <v-icon
                                style="padding-left: 5px"
                                small
                                v-bind="attrs"
                                v-on="on"
                                :color="color"
                              >
                                mdi-alert-circle-outline
                              </v-icon>
                            </template>
                            <span
                              >Se existem usuários cadastrados (considerando o
                              filtro), houve um erro de rede. Certifique-se de
                              sua conexão e atualize a página</span
                            >
                          </v-tooltip>
                        </div>
                      </template>
                    </v-autocomplete>
                  </v-col>
                </v-row>
              </v-form>
            </v-list-item-content>

            <v-list-item-action class="mt-6" style="display: inline-block">
              <v-tooltip id="tooltip" left color="orange">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn
                    class="mr-2"
                    icon
                    v-bind="attrs"
                    v-on="on"
                    @click="modalEditProfile(item)"
                  >
                    <v-icon color="orange">mdi-badge-account</v-icon>
                  </v-btn>
                </template>
                <span>Editar Perfil</span>
              </v-tooltip>
              <v-tooltip
                id="tooltip"
                left
                :color="item.active ? 'success' : 'error'"
              >
                <template v-slot:activator="{ on, attrs }">
                  <v-btn
                    icon
                    :loading="loading_active[item.id]"
                    v-bind="attrs"
                    v-on="on"
                    @click="
                      loading_active[item.id] = true;
                      changeAccess(item.id, false, item.active);
                    "
                  >
                    <v-icon v-if="item.active" color="green"
                      >mdi-check-circle</v-icon
                    >
                    <v-icon v-else color="red">mdi-close-circle</v-icon>
                  </v-btn>
                </template>
                <span v-if="item.active"
                  >Usuário Ativo (Clique para desativá-lo)</span
                >
                <span v-else>Usuário Desativado (Clique para ativá-lo)</span>
              </v-tooltip>
            </v-list-item-action>
          </v-list-item>
        </v-list>
      </v-card-text>
      <v-card-actions v-if="!loading">
        <span
          :style="dark_theme ? 'color: white' : ''"
          class="bold page-items-text mx-3"
          >Itens por página:</span
        >
        <div style="max-width: 37px">
          <v-form ref="form_page_items" v-model="valid_page" lazy-validation>
            <vuetify-number
              class="page-items-textfield"
              v-model="page_total_items"
              v-bind:rules="requiredRule"
              v-bind:options="options"
              v-bind:backgroundColor="dark_theme ? 'rgb(30, 30, 31)' : ''"
            />
          </v-form>
        </div>

        <v-spacer></v-spacer>
        <v-pagination
          v-model="page"
          style="font-weight: bold"
          circle
          :length="total_pages"
          :total-visible="5"
        ></v-pagination>
      </v-card-actions>
    </v-card>
    <modal-edit
      :open="modal_profile"
      :user="modal_profile_user"
      @closeModal="modalEditProfile"
    ></modal-edit>
  </div>
</template>

<script>
import ModalEdit from './Modals/ModalEditProfile.vue';
export default {
  name: 'UsersComponent',
  components: { ModalEdit },
  data: () => ({
    total_items: [],
    items: [],
    accesses: [],
    total_pages: 1,
    page_total_items: 10,
    page: 1,
    i: -1,
    loading: false,
    loading_access: {},
    loading_all_accesses: false,
    modal_profile: false,
    modal_profile_user: {},
    snackbar_profile: false,
    loading_active: {},
    valid_access: true,
    valid_page: true,
    color: 'orange',
    requiredRule: [(v) => v > 0 || 'x > 0'],
    options: {
      locale: 'pt-BR',
      prefix: '',
      suffix: '',
      length: 2,
      precision: 0,
    },
    requiredAccessRule: [(v) => !!v || 'Essa informação é obrigatória'],
  }),
  created() {
    this.getUsers();
  },
  watch: {
    page: function () {
      this.pagination(false);
    },
    page_total_items: function () {
      if (this.$refs.form_page_items.validate()) {
        this.pagination(true, 1);
      } else {
        this.page_total_items = 10;
        this.pagination(true, 1);
      }
    },
  },
  computed: {
    dark_theme() {
      return this.$store.state.user.configs.theme == 0;
    },
  },
  methods: {
    loading_access_computed(id) {
      return this.loading_access[id] || this.loading_all_accesses;
    },
    changeAccess(user_id, access_id, active = -1) {
      if (!access_id && active == -1) {
        this.loading_access[user_id] = false;
        return 505;
      }
      this.$http
        .put(`edit_user_access/${user_id}`, {
          access_id: access_id,
          active: active,
        })
        .then((response) => {
          if (access_id) {
            this.loading_access[user_id] = false;
          } else {
            this.total_items = this.total_items.map((user) =>
              user.id !== user_id ? user : response.data
            );
            this.loading_active[user_id] = false;
          }
          this.pagination(false);
        });
    },
    pagination(reload_total_pages = true, page = this.page) {
      if (reload_total_pages) {
        this.total_pages = Math.ceil(
          this.total_items.length / this.page_total_items
        );
      }
      this.page_total_items = parseInt(this.page_total_items);
      let begin = (page - 1) * this.page_total_items;
      let end = begin + this.page_total_items;
      this.items = this.total_items.slice(begin, end);
    },
    getAccesses() {
      this.loading_all_accesses = true;
      this.$http.get('get_accesses').then((response) => {
        this.accesses = response.data;
        this.loading_all_accesses = false;
      });
    },
    getUsers() {
      this.loading = true;
      this.$http.post('get_users').then((response) => {
        this.total_items = response.data;
        this.pagination();
        this.loading = false;
        this.getAccesses();
      });
    },
    avatar_path(photo_path) {
      return require('../../../backend/storage/app/' + photo_path);
    },
    modalEditProfile(user, edit = true) {
      if (!this.modal_profile) {
        Object.assign(this.modal_profile_user, user);
        this.modal_profile_user.current_password =
          this.modal_profile_user.password;
        Object.assign(this.modal_profile_user, { password: null });
      } else {
        this.modal_profile_user = {};
        if (edit) {
          this.total_items = this.total_items.map((user_map) =>
            user_map.id !== user.id ? user_map : user
          );
          this.pagination(false);
          this.snackbar_profile = true;
        }
      }
      this.modal_profile = !this.modal_profile;
    },
  },
};
</script>
<style scoped>
.tooltip-text {
  font-family: 'Quicksand', 'sans-serif';
  font-weight: bold;
  display: inline-block;
}

.tooltip-icon-sicoob {
  position: absolute;
  top: 0px;
  right: 1px;
  display: inline-block;
}

.tooltip-icon-right {
  margin-bottom: 6px;
  margin-left: 3px;
  display: inline-block;
}
</style>