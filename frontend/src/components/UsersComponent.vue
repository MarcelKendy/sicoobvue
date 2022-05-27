<template>
  <div>
    <v-card
      class="font-quicksand hover-card"
      shaped
      elevation="4"
      :loading="loading"
      outlined
    >
      <v-card-title>
        <span class="bold title-card">Usuários do Sistema</span>
      </v-card-title>
      <v-card-subtitle>
        <span class="bold subtitle-card">Controle de usuários</span>
      </v-card-subtitle>
      <v-card-text>
        <v-list three-line v-for="(item, index) in items" :key="index"  >
          <v-list-item :key="index + 0.1" class="list-item">
            <v-list-item-avatar class="mt-6">
              <v-img v-if="item.photo" :src="item.photo"></v-img>
              <v-img
                v-else-if="item.gender == 1"
                src="./../assets/icons/man.png"
              ></v-img>
              <v-img v-else src="./../assets/icons/woman.png"></v-img>
            </v-list-item-avatar>
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
              <span>{{ item.role }}</span>
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
                      placeholder="Enter para confirmar"
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
                          <v-tooltip top>
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

            <v-list-item-action class="mt-6">
              <v-tooltip left>
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
      <v-card-actions>
        <span class="bold page-items-text mx-3">Itens por página:</span>
        <div style="max-width: 37px">
          <v-form ref="form_page_items" v-model="valid_page" lazy-validation>
            <vuetify-number
              class="page-items-textfield"
              v-model="page_total_items"
              v-bind:rules="requiredRule"
              v-bind:color="color"
              v-bind:options="options"
            />
          </v-form>
        </div>

        <v-spacer></v-spacer>
        <v-pagination
          v-model="page"
          style="font-weight: bold"
          circle
          :length="total_pages"
          :total-visible="4"
        ></v-pagination>
      </v-card-actions>
    </v-card>
  </div>
</template>

<script>
export default {
  name: 'UsersComponent',

  data: () => ({
    total_items: [],
    items: [],
    accesses: [],
    total_pages: 1,
    page_total_items: 4,
    page: 1,
    i: -1,
    loading: false,
    loading_access: {},
    loading_all_accesses: false,
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
        this.pagination();
      } else {
        this.page_total_items = 4;
        this.pagination();
      }
    },
  },
  methods: {
    loading_access_computed(id) {
      return this.loading_access[id] || this.loading_all_accesses;
    },
    changeAccess(user_id, access_id, active = -1) {
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
    pagination(reload_total_pages = true) {
      if (reload_total_pages) {
        this.total_pages = Math.ceil(
          this.total_items.length / this.page_total_items
        );
      }
      this.page_total_items = parseInt(this.page_total_items);
      let begin = (this.page - 1) * this.page_total_items;
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
        console.log(response.data);
        this.total_items = response.data;
        this.pagination();
        this.loading = false;
        this.getAccesses();
      });
    },
  },
};
</script>
<style scoped>
.list-item {
  transition: 0.3s;
  
box-shadow: 0px 0px 6px -1px #000000;
}
.list-item:hover {
  box-shadow: rgba(0, 0, 0, 0.32) 0px 9px 12px, rgba(0, 0, 0, 0.46) 0px 9px 12px;
}
</style>