<template>
  <div>
    <v-dialog v-model="dialog" persistent max-width="700">
      <!--<v-img src="@/assets/uploads/avatars/about.png"></v-img>-->
      <v-card :dark="dark_theme" :loading="loading">
        <template slot="progress">
          <v-progress-linear
            :color="color"
            height="10"
            indeterminate
          ></v-progress-linear>
        </template>
        <v-card-title class="title-modal" v-if="!loading">
          <strong>Editar Perfil</strong>
          <v-spacer></v-spacer>
          <img width="30" src="../../assets/images/logos/sicoobicon.png" />
        </v-card-title>
        <v-card-title class="title-modal" v-else>
          <strong>Salvando</strong>
          <v-spacer></v-spacer>
          <img width="50" src="../../assets/images/loading.gif" />
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text class="mt-7" v-if="loading">
          <v-row align="center" justify="center">
            <v-col cols="12">
              <v-alert
                :color="color"
                border="left"
                elevation="3"
                dark
                icon="mdi-content-save"
              >
                <span>Espera só um pouquinho, carregando...</span>
              </v-alert>
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-text
          class="mt-4"
          v-else
          style="font-family: 'Quicksand', sans-serif; font-weight: 700"
        >
          <v-form ref="form" v-model="valid" lazy-validation>
            <v-row class="align-center">
              <v-col cols="12">
                <v-text-field
                  v-model="item.full_name"
                  :rules="requiredRule"
                  label="Nome Completo"
                  :color="color"
                  placeholder="Fulano da Silva"
                  name="register_full_name"
                  maxlength="50"
                  prepend-icon="mdi-account"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" v-if="admin">
                <v-autocomplete
                  :menu-props="{ dark: dark_theme }"
                  :loading="loading_roles"
                  label="Função na Cooperativa"
                  :color="color"
                  prepend-icon="mdi-briefcase"
                  placeholder="Enter para confirmar"
                  :rules="requiredRuleRole"
                  v-model="item.role_id"
                  :items="roles"
                  item-text="name"
                  item-value="id"
                  auto-select-first
                  solo
                  clearable
                >
                  <template v-slot:no-data>
                    <div class="px-4">
                      <span
                        style="
                          font-family: 'Quicksand', sans-serif;
                          font-weight: bold;
                        "
                        >Falha ao carregar os cargos da cooperativa</span
                      >
                      <v-tooltip top :color="dark_theme ? 'grey darken-3' : ''">
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
                        <span>Não existem cargos com essa filtragem</span>
                      </v-tooltip>
                    </div>
                  </template>
                </v-autocomplete>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-text-field
                  v-model="item.email"
                  :rules="emailRule"
                  placeholder="email@email.com"
                  label="E-mail"
                  :color="color"
                  name="register_email"
                  required
                  prepend-icon="mdi-email"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-text-field-simplemask
                  label="CPF"
                  v-model="item.cpf"
                  v-bind:properties="{
                    color: color,
                    rules: cpfRule,
                    name: 'register_cpf',
                    placeholder: '000.000.000-00',
                    required: true,
                    prependIcon: 'mdi-id-card',
                  }"
                  v-bind:options="{
                    inputMask: '###.###.###-##',
                    outputMask: '###########',
                    empty: null,
                    applyAfter: false,
                    numeric: true,
                    lowerCase: false,
                  }"
                />
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-text-field-simplemask
                  label="Ramal"
                  v-model="item.phone_corporation"
                  v-bind:properties="{
                    color: color,
                    rules: ramalRule,
                    name: 'register_phone_corporation',
                    placeholder: '1500',
                    required: true,
                    prependIcon: 'mdi-card-account-phone',
                  }"
                  v-bind:options="{
                    inputMask: '####',
                    outputMask: '####',
                    empty: null,
                    applyAfter: false,
                    numeric: true,
                    lowerCase: false,
                  }"
                />
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-text-field-simplemask
                  label="Número de contato"
                  v-model="item.phone"
                  v-bind:properties="{
                    color: color,
                    
                    name: 'register_phone',
                    placeholder: '(00) 00000-0000',
                    required: true,
                    prependIcon: 'mdi-cellphone',
                  }"
                  v-bind:options="{
                    inputMask: '(##) #####-####',
                    outputMask: '(##) #####-####',
                    empty: null,
                    applyAfter: false,
                    numeric: true,
                    lowerCase: false,
                  }"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  label="Endereço"
                  v-model="item.address"
                  placeholder="São Gotardo, Av. João Cardoso 689"
                  :color="color"
                  name="register_address"
                  maxlength="50"
                  required
                  counter="50"
                  prepend-icon="mdi-map-marker"
                  
                />
              </v-col>
              <v-col cols="12">
                <v-file-input
                  v-model="item.photo"
                  accept="image/*"
                  label="Alterar Foto de Perfil"
                  :color="color"
                  placeholder="Insira apenas imagens"
                  prepend-icon="mdi-camera"
                  show-size
                  truncate-length="40"
                ></v-file-input>
              </v-col>
              <v-col cols="6">
                <v-tooltip id="tooltip" right :color="color">
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn
                      v-bind="attrs"
                      v-on="on"
                      :color="color"
                      small
                      @click="others = !others"
                      dark
                    >
                      Outros <v-icon right>mdi-plus-circle</v-icon>
                    </v-btn>
                  </template>
                  <span>Outras informações</span>
                </v-tooltip>
              </v-col>
              <v-slide-y-transition>
                <v-row v-if="others">
                  <v-col cols="12" sm="6" md="6">
                    <v-select
                      :menu-props="{ offsetY: true, dark: dark_theme }"
                      solo
                      :items="agencies"
                      item-text="text"
                      item-value="value"
                      :color="color"
                      :rules="requiredRule"
                      label="Agência"
                      v-model="item.agency"
                      prepend-icon="mdi-domain"
                    >
                    </v-select>
                  </v-col>
                  <v-col cols="12" sm="6" md="6">
                    <v-select
                      :menu-props="{ offsetY: true, dark: dark_theme }"
                      solo
                      :items="genders"
                      item-text="text"
                      item-value="value"
                      :color="color"
                      :rules="requiredRule"
                      label="Gênero"
                      v-model="item.gender"
                      prepend-icon="mdi-gender-male-female"
                    >
                      <template v-slot:selection="{ item }">
                        <div
                          :class="
                            'chip gradient-' +
                            genderStyle(item.value, 'gradient')
                          "
                        >
                          <div class="chip__content">
                            <v-icon dark>{{
                              genderStyle(item.value, 'icon')
                            }}</v-icon>
                          </div>
                        </div>
                      </template>
                      <template v-slot:item="{ item }">
                        <div
                          :class="
                            'chip gradient-' +
                            genderStyle(item.value, 'gradient')
                          "
                        >
                          <div class="chip__content">
                            <v-icon small dark>{{
                              genderStyle(item.value, 'icon')
                            }}</v-icon>
                            <span class="item-select-badge">{{
                              item.text
                            }}</span>
                          </div>
                        </div>
                      </template>
                    </v-select>
                  </v-col>
                </v-row>
              </v-slide-y-transition>
              <v-col cols="12">
                <v-tooltip id="tooltip" right color="orange">
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn
                      v-bind="attrs"
                      v-on="on"
                      color="orange"
                      dark
                      small
                      @click="change_password = !change_password"
                    >
                      <strong>Senha</strong>
                      <v-icon>{{
                        change_password ? 'mdi-lock-minus' : 'mdi-lock-plus'
                      }}</v-icon>
                    </v-btn>
                  </template>
                  <span class="font-quicksand">{{
                    change_password
                      ? 'Fechar Cartão de Senha'
                      : 'Abrir Cartão de Senha'
                  }}</span>
                </v-tooltip>
              </v-col>
              <v-slide-y-transition>
                <v-card
                  v-if="change_password"
                  class="mx-auto pa-2"
                  elevation="10"
                  :color="dark_theme ? 'yellow darken-4' : 'yellow lighten-4'"
                >
                  <v-card-title color="orange" style="font-weight: bold">
                    Alterar Senha
                    <v-tooltip id="tooltip" right :color="dark_theme ? 'grey darken-3' : ''">
                      <template v-slot:activator="{ on, attrs }">
                        <v-icon
                          class="mx-2"
                          :color="dark_theme ? 'white' : 'orange'"
                          v-bind="attrs"
                          v-on="on"
                          >mdi-alert-octagon-outline</v-icon
                        >
                      </template>
                      <span>Essa ação é irreversível</span>
                    </v-tooltip>
                  </v-card-title>
                  <v-card-subtitle>
                    A nova senha entrará em vigor no seu próximo Login.
                  </v-card-subtitle>
                  <v-card-text class="bold">
                    <v-row align="center" justify="center">
                      <v-col cols="12">
                        <v-text-field
                          v-model="item.password"
                          :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
                          :rules="passwordRule"
                          :type="show ? 'text' : 'password'"
                          name="register_password"
                          label="Nova senha"
                          counter
                          :color="dark_theme ? 'white' : 'orange'"
                          @click:append="show = !show"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12">
                        <v-text-field
                          block
                          @keyup.enter="editProfile()"
                          v-model="item.verify"
                          :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
                          :rules="[rules.verifyPasswordRule, matchPasswords]"
                          :type="show ? 'text' : 'password'"
                          name="verify_password"
                          label="Confirmar nova senha"
                          :color="dark_theme ? 'white' : 'orange'"
                          counter
                          @click:append="show = !show"
                        ></v-text-field>
                      </v-col>
                    </v-row>
                  </v-card-text>
                </v-card>
              </v-slide-y-transition>
            </v-row>
          </v-form>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions v-if="!loading">
          <v-spacer></v-spacer>
          <v-btn color="red darken-1" dark text @click="closeModal()">
            Cancelar
          </v-btn>
          <v-btn
            :color="color"
            :disabled="loading_roles"
            text
            @click="editProfile()"
          >
            Salvar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import FormData from 'form-data';
export default {
  props: {
    open: {
      type: [Boolean],
    },
    user: {},
  },
  components: {},
  data() {
    return {
      color: 'blue',
      valid: true,
      dialog: false,
      others: false,
      change_password: false,
      loading: false,
      loading_roles: false,
      show: false,
      roles: [],
      item: {
        full_name: '',
        email: '',
        cpf: '',
        active: '',
        photo: null,
        password: '',
        verify: '',
        role_id: '',
        department: '',
        address: '',
        phone: '',
        phone_corporation: '',
        agency: '',
        gender: '',
      },
      /* RULES */
      requiredRule: [(v) => !!v || 'Essa informação é obrigatória'],
      requiredRuleRole: [(v) => (v == 0 || !!v) || 'Essa informação é obrigatória'],
      cpfRule: [
        (v) => !!v || 'Digite o seu CPF',
        (v) => /^\d{3}\.\d{3}\.\d{3}-\d{2}$/.test(v) || 'CPF inválido',
      ],
      emailRule: [
        (v) => !!v || 'Digite o seu E-mail',
        (v) => /.+@.+\..+/.test(v) || 'E-mail inválido',
      ],
      ramalRule: [
        (v) =>
          ((!v) || (!!v && v.length > 1 && v[0] == 1 && v[1] == 5)) ||
          'Atualmente, todos os ramais começam com 15. (Exemplo: 1506)',
        (v) =>
          ((!v) || (!!v && v.length == 4)) ||
          'Atualmente, todos os ramais possuem 4 dígitos. (Exemplo: 1506)',
      ],
      photoRule: [
        (value) =>
          !!value ||
          'Isso não é uma imagem. Formatos aceitos: .png, .jpg, etc...',
      ],
      passwordRule: [
        (v) => !!v || 'Digite sua senha',
        (v) => (v && v.length >= 5) || 'No mínimo 5 caracteres',
        (v) => /[0-9]/.test(v) || 'É necessário ao menos um número',
        (v) => /\W|_/.test(v) || 'É necessário ao menos um caracter especial',
      ],
      rules: {
        verifyPasswordRule: (value) => !!value || 'Confirme a sua senha',
      },
      agencies: [
        { text: 'Matriz', value: 1 },
        { text: 'PA-01', value: 2 },
      ],
      genders: [
        { text: 'Masc.', value: 1 },
        { text: 'Fem.', value: 2 },
      ],
      gender_style: [
        {
          gender: 1,
          color: 'white',
          icon: 'mdi-face-man-shimmer',
          gradient: 'blue',
        },
        {
          gender: 2,
          color: 'white',
          icon: 'mdi-face-woman-shimmer',
          gradient: 'pink',
        },
      ],
    };
  },
  watch: {
    open: function () {
      this.dialog = this.open;
      if (this.dialog) {
        this.loading = false;
        this.assignUser();
      }
    },
    change_password: function () {
      this.item.verify = this.item.password = '';
    },
  },
  methods: {
    assignUser() {
      Object.assign(Object.assign(this.item, this.defaultItem), this.user);
      this.admin ? this.getRoles() : '';
      this.item.photo = null;
    },
    getRoles() {
      this.loading_roles = true;
      this.$http.get('get_roles').then((response) => {
        this.roles = response.data;
        this.roles = this.roles.map(function (role) {
          return {id: role.id, name: role.name + ' - ' + role.department.name};
        });
        this.loading_roles = false;
      });
    },
    editProfile() {
      if (this.$refs.form.validate()) {
        this.loading = true;
        this.others = this.change_password = false;
        this.$http
          .put(`edit_user/${this.item.id}`, this.item)
          .then((response) => {
            if (this.item.photo) {
              let form_data = new FormData();
              form_data.append('photo', this.item.photo);
              form_data.append('name', this.item.photo.name);
              form_data.append('user_id', this.item.id);
              this.$http
                .post('/store_avatar', form_data, {
                  headers: { 'Content-Type': 'multipart/form-data' },
                })
                .then((response) => {
                  if (this.$store.state.user.id == response.data.id) {
                    this.$store
                      .dispatch('login', response.data)
                      .then(this.$emit('closeModal', response.data));
                  } else {
                    this.$emit('closeModal', response.data);
                  }
                  if (this.$refs.form) {
                    this.$refs.form.reset();
                  }
                });
            } else {
              if (this.$store.state.user.id == response.data.id) {
                this.$store
                  .dispatch('login', response.data)
                  .then(this.$emit('closeModal', response.data));
              } else {
                this.$emit('closeModal', response.data);
              }
              if (this.$refs.form) {
                this.$refs.form.reset();
              }
            }
          });
      }
    },
    genderStyle(gender, type) {
      let value = '';
      this.gender_style.forEach((item) => {
        if (item.gender == gender) {
          if (type == 'color') {
            value = item.color;
          } else if (type == 'icon') {
            value = item.icon;
          } else {
            value = item.gradient;
          }
        }
      });
      return value;
    },
    closeModal() {
      this.$refs.form.resetValidation();
      this.others = this.change_password = false;
      this.$emit('closeModal', null, false);
    },
  },
  computed: {
    dark_theme() {
      try {
        return this.$store.state.user.configs.theme == 0;
      } catch (err) {
        return false;
      }
    },
    admin() {
      try {
        return this.$store.state.user.accesses.users == 1;
      } catch (err) {
        return false;
      }
    },
    matchPasswords() {
      return (
        this.item.password === this.item.verify || 'As senhas não coincidem'
      );
    },
    defaultItem() {
      return {
        full_name: '',
        email: '',
        active: '',
        cpf: '',
        photo: null,
        password: '',
        address: '',
        verify: '',
        role_id: '',
        department: '',
        phone: '',
        phone_corporation: '',
        agency: '',
        gender: '',
      };
    },
  },
};
</script>

<style scoped>
.title-modal {
  font-family: 'Quicksand', sans-serif;
  color: rgb(80, 150, 240);
}
.item-select-badge {
  font-weight: bold;
  padding-left: 5px;
}
</style>