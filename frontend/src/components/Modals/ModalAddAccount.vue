<template>
  <div>
    <v-dialog v-model="dialog" persistent max-width="700">
      <v-card :loading="loading" :dark="dark_theme">
        <template slot="progress">
          <v-progress-linear
            :color="color"
            height="10"
            indeterminate
          ></v-progress-linear>
        </template>
        <v-card-title class="title-modal" v-if="!loading">
          <strong :style="'color:' + color">{{
            (type == 'edit' ? 'Editar' : 'Adicionar') + ' Conta'
          }}</strong>
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
        <v-card-text class="mt-4" v-else>
          <v-form ref="form" v-model="valid" lazy-validation>
            <v-row align="center">
              <v-col cols="12">
                <v-text-field
                  outlined
                  :color="color"
                  label="Associado"
                  :rules="requiredRule"
                  v-model="item.associate"
                  placeholder="Nome COMPLETO do Associado"
                  prepend-icon="mdi-account"
                >
                </v-text-field>
              </v-col>
            </v-row>
            <v-row align="center">
              <v-col cols="12" md="6">
                <v-text-field-simplemask
                  label="CPF/CNPJ"
                  v-model="item.cpf_cnpj"
                  v-bind:properties="{
                    outlined: true,
                    color: color,
                    rules: cpfcnpjRule,
                    name: 'register_cpf',
                    placeholder: '000.000.000-00|00.000.000/0000-00',
                    required: true,
                    prependIcon: 'mdi-id-card',
                  }"
                  v-bind:options="
                    is_cnpj
                      ? {
                          inputMask: '##.###.###/####-##',
                          outputMask: '##.###.###/####-##',
                          empty: null,
                          applyAfter: false,
                          numeric: true,
                          lowerCase: false,
                        }
                      : {
                          inputMask: '###.###.###-###',
                          outputMask: '###.###.###-###',
                          empty: null,
                          applyAfter: false,
                          numeric: true,
                          lowerCase: false,
                        }
                  "
                />
              </v-col>
              <v-col cols="12" md="6">
                <v-text-field-simplemask
                  label="Número de contato"
                  v-model="item.phone"
                  v-bind:properties="{
                    color: color,
                    outlined: true,
                    rules: requiredAutoCompleteRule,
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
            </v-row>
            <v-row align="center">
              <v-col cols="12" md="6">
                <v-text-field
                  outlined
                  :color="color"
                  label="Conta"
                  :rules="requiredRule"
                  v-model="item.account"
                  @keypress="accountMask"
                  placeholder="Número com ponto(s) e traço"
                  prepend-icon="mdi-account-cash"
                >
                </v-text-field>
              </v-col>
              <v-col cols="12" md="6">
                <v-text-field
                  outlined
                  :color="color"
                  label="Grupo"
                  v-model="item.group"
                  placeholder="Insira o grupo se houver"
                  prepend-icon="mdi-account-group"
                >
                </v-text-field>
              </v-col>
            </v-row>
            <v-row align="center">
              <v-col cols="12" md="6">
                <v-autocomplete
                  :menu-props="{ offsetY: true, dark: dark_theme }"
                  outlined
                  :items="account_types"
                  item-text="name"
                  item-value="value"
                  :rules="requiredAutoCompleteRule"
                  :color="color"
                  label="Tipo de Conta"
                  v-model="item.account_type"
                  prepend-icon="mdi-bank"
                  auto-select-first
                >
                </v-autocomplete>
              </v-col>
              <v-col cols="12" md="6">
                <v-select
                  :menu-props="{ offsetY: true, dark: dark_theme }"
                  outlined
                  item-text="name"
                  item-value="value"
                  :items="account_categories"
                  :rules="requiredRule"
                  :color="color"
                  label="Categoria de Conta"
                  v-model="item.category"
                  prepend-icon="mdi-card-account-details"
                >
                </v-select>
              </v-col>
            </v-row>
          </v-form>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions v-if="!loading">
          <v-spacer></v-spacer>
          <v-btn color="red darken-1" dark text @click="closeModal()">
            Cancelar
          </v-btn>
          <v-btn :color="color" text @click="addAccount()"> Salvar </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  props: {
    open: {},
    account: { default: null },
    type: { type: String, default: 'add' },
  },
  data() {
    return {
      color: 'rgb(0, 209, 94)',
      valid: true,
      dialog: false,
      loading: false,
      item: {
        original_account: '',
        id: '',
        user_id: this.$store.state.user.id,
        associate: '',
        cpf_cnpj: '',
        phone: '',
        account: '',
        account_type: '',
        category: '',
        group: '',
      },
      account_types: [
        { value: 'PESSOAS FÍSICAS', name: 'Pessoas Físicas' },
        { value: 'PESSOAS JURÍDICAS', name: 'Pessoas Jurídicas' },
        { value: 'DEP. GOV. ADM DIRETA', name: 'Dep. Gov. Adm Direta' },
        {
          value: 'CTA.GARANTIDA CORRESPONDENTE',
          name: 'Cta.Garantida Correspondente',
        },
        { value: 'CORRESPONDENTE NO PAÍS', name: 'Correspondente no País' },
        { value: 'CONTA UNIVERSITÁRIA', name: 'Conta Universitária' },
        { value: 'CONTA DIGITAL', name: 'Conta Digital' },
        { value: 'CONTA DIGITAL PJ', name: 'Conta Digital PJ' },
        { value: 'CONTA UNIVERSITÁRIA', name: 'Conta Universitária' },
        {
          value: 'CONTA CHEQUE ORDEM DE PAGAMENTO',
          name: 'Conta Cheque Ordem de Pagamento',
        },
        { value: 'CHEQUE ADMINISTRATIVO', name: 'Cheque Administrativo' },
      ],
      account_categories: [
        { value: 'INDIVIDUAL', name: 'Individual' },
        { value: 'CONJUNTA SOLIDÁRIA', name: 'Conjunta Solidária' },
        { value: 'CONJUNTA NÃO SOLIDÁRIA', name: 'Conjunta Não Solidária' },
      ],
      categories_style: [
        {
          name: 'INDIVIDUAL',
          color: 'green',
          icon: 'mdi-lock-open-check',
          gradient: 'success',
        },
        {
          name: 'CONJUNTA SOLIDÁRIA',
          color: 'red',
          icon: 'mdi-lock',
          gradient: 'error',
        },
        {
          name: 'CONJUNTA NÃO SOLIDÁRIA',
          color: 'red',
          icon: 'mdi-lock',
          gradient: 'error',
        },
      ],

      /* RULES */
      requiredAutoCompleteRule: [(v) => !!v || 'Essa informação é obrigatória'],
      requiredRule: [(v) => !!v || 'Essa informação é obrigatória'],
      cpfcnpjRule: [
        (v) => !!v || 'Digite CPF/CNPJ' /* eslint-disable */,
        (v) =>
          /(^\d{3}\.\d{3}\.\d{3}\-\d{2}$)|(^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$)/.test(
            v
          ) || 'CPF/CNPJ inválido',
      ],
    };
  },
  watch: {
    open: function () {
      this.dialog = this.open;
      if (this.$refs.form) {
        this.$refs.form.resetValidation();
      }
      if (this.dialog) {
        this.color = this.type == 'edit' ? 'orange' : 'rgb(0, 209, 94)';
        this.loading = false;
        if (this.type == 'edit' && this.account) {
          Object.assign(this.item, this.account);
          this.item.original_account = this.item.account
        }
      }
    },
  },
  methods: {
    accountMask($event) {
      //console.log($event.keyCode); //keyCodes value
      let keyCode = $event.keyCode ? $event.keyCode : $event.which;
      if ((keyCode < 48 || keyCode > 57) && keyCode !== 46 && keyCode !== 45) {
        // 46 is dot
        // 45 is hyphen
        // numbers are between 48 and 57
        $event.preventDefault();
      }
    },
    resetValidation() {
      if (this.$refs.form) {
        this.$refs.form.resetValidation();
      }
    },
    accountStyle(name, type) {
      let value = '';
      this.account_style.forEach((item) => {
        if (item.name == name) {
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
    addAccount() {
      if (this.$refs.form.validate()) {
        this.loading = true;
        this.item.associate = this.item.associate.toUpperCase();
        this.type == 'add'
          ? this.$emit('addAccount', this.item)
          : this.$emit('editAccount', this.item);
        this.$refs.form.resetValidation();
        Object.assign(this.item, this.defaultItem);
      }
    },
    closeModal() {
      this.$emit('closeAddModal');
      this.$refs.form.resetValidation();
      Object.assign(this.item, this.defaultItem);
    },
  },
  computed: {
    is_cnpj() {
      return this.item.cpf_cnpj.length > 14;
    },
    dark_theme() {
      try {
        return this.$store.state.user.configs.theme == 0;
      } catch (err) {
        return false;
      }
    },
    defaultItem() {
      return {
        original_account: '',
        id: '',
        user_id: this.$store.state.user.id,
        associate: '',
        cpf_cnpj: '',
        phone: '',
        account: '',
        account_type: '',
        category: '',
        group: '',
      };
    },
  },
};
</script>

<style scoped>
.title-modal {
  font-family: 'Quicksand', sans-serif;
  color: rgb(0, 209, 94);
}
.item-select-badge {
  font-family: 'Quicksand', sans-serif;
  font-size: 13px;
  padding-left: 5px;
}
.chip {
  max-width: 180px;
  min-width: 150px;
  max-height: 30px;
  flex: 1 1 auto;
  transition: 0.3s;
  background-size: 200% auto;
  align-items: center;
  display: inline-flex;
  justify-content: center;
  background-color: black;
  border-radius: 9999px;
  padding: 4px 8px;
}
.gradient-blue {
  background-image: linear-gradient(to right, #77caf3, #5b75dc, #77caf3);
}
.gradient-gray {
  background-image: linear-gradient(to right, #a0b7c0, #5f6e8b, #a0b7c0);
}
.gradient-orange {
  background-image: linear-gradient(to right, #fcc53b, #fa7618, #fcc53b);
}
.gradient-success {
  background-image: linear-gradient(to right, #49f87d, #40bfff, #49f87d);
}
.gradient-error {
  background-image: linear-gradient(to right, #ff648e, #ca0000, #ff648e);
}
.chip:hover {
  background-position: right center; /* change the direction of the change here */
}
.chip__content {
  color: white;
  margin-right: 1px;
}
</style>