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
          <strong>Adicionar Acesso</strong>
          <v-spacer></v-spacer>
          <img width="30" src="../../assets/images/sicoobicon.png" />
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
                  label="Nome do Acesso"
                  :rules="requiredRule"
                  v-model="item.name"
                  placeholder="Insira uma descrição para este acesso"
                  prepend-icon="mdi-pencil"
                >
                </v-text-field>
              </v-col>
            </v-row>
            <v-row align="center">
              <v-col cols="12">
                <v-select
                  :menu-props="{ offsetY: true }"
                  outlined
                  :items="accesses_accesses"
                  item-text="name"
                  item-value="value"
                  :rules="requiredRule"
                  :color="color"
                  label="Tela de acessos"
                  v-model="item.access"
                  prepend-icon="mdi-monitor-lock"
                >
                  <template v-slot:selection="{ item }">
                    <div
                      :class="
                        'chip gradient-' + accessStyle(item.value, 'gradient')
                      "
                    >
                      <div class="chip__content">
                        <v-icon color="white">{{
                          accessStyle(item.value, 'icon')
                        }}</v-icon>
                        <span class="item-select-badge">{{ item.name }}</span>
                      </div>
                    </div>
                  </template>
                  <template v-slot:item="{ item }">
                    <div
                      :class="
                        'chip gradient-' + accessStyle(item.value, 'gradient')
                      "
                    >
                      <div class="chip__content">
                        <v-icon color="white">{{
                          accessStyle(item.value, 'icon')
                        }}</v-icon>
                        <span class="item-select-badge">{{ item.name }}</span>
                      </div>
                    </div>
                  </template>
                </v-select>
              </v-col>
            </v-row>
            <v-row align="center">
              <v-col cols="12">
                <v-select
                  :menu-props="{ offsetY: true }"
                  outlined
                  :items="commissions_accesses"
                  item-text="name"
                  item-value="value"
                  :rules="requiredRule"
                  :color="color"
                  label="Tela de comissões"
                  v-model="item.commission"
                  prepend-icon="mdi-cash"
                >
                  <template v-slot:selection="{ item }">
                    <div
                      :class="
                        'chip gradient-' +
                        commissionStyle(item.value, 'gradient')
                      "
                    >
                      <div class="chip__content">
                        <v-icon :color="commissionStyle(item.value, 'color')">{{
                          commissionStyle(item.value, 'icon')
                        }}</v-icon>
                        <span class="item-select-badge">{{ item.name }}</span>
                      </div>
                    </div>
                  </template>
                  <template v-slot:item="{ item }">
                    <div
                      :class="
                        'chip gradient-' +
                        commissionStyle(item.value, 'gradient')
                      "
                    >
                      <div class="chip__content">
                        <v-icon :color="commissionStyle(item.value, 'color')">{{
                          commissionStyle(item.value, 'icon')
                        }}</v-icon>
                        <span class="item-select-badge">{{ item.name }}</span>
                      </div>
                    </div>
                  </template>
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
          <v-btn :color="color" text @click="addAccess()"> Salvar </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  props: ['open'],
  data() {
    return {
      color: 'rgb(0, 209, 94)',
      valid: true,
      dialog: false,
      loading: false,
      users: [],
      item: {
        user_id: this.$store.state.user.id,
        name: '',
        accesses: { accesses: '', commissions: '' },
        access: '',
        commission: '',
      },
      accesses_accesses: [
        { value: 1, name: 'Permitido' },
        { value: 0, name: 'Bloqueado' },
      ],
      commissions_accesses: [
        { value: 'indicator', name: 'Indicador' },
        { value: 'seller', name: 'Vendedor' },
        { value: 'operator', name: 'Operador' },
      ],
      access_style: [
        {
          name: 1,
          color: 'green',
          icon: 'mdi-lock-open-check',
          gradient: 'success',
        },
        {
          name: 0,
          color: 'red',
          icon: 'mdi-lock',
          gradient: 'error',
        },
      ],
      commission_style: [
        {
          name: 'indicator',
          color: '#5b75dc',
          icon: 'mdi-bullhorn-outline',
          gradient: 'blue',
        },
        {
          name: 'seller',
          color: '#5f6e8b',
          icon: 'mdi-account-tie-voice',
          gradient: 'gray',
        },
        {
          name: 'operator',
          color: 'orange darken-3',
          icon: 'mdi-account-tie',
          gradient: 'orange',
        },
      ],

      /* RULES */
      requiredRule: [(v) => v.length != 0 || 'Essa informação é obrigatória'],
    };
  },
  watch: {
    open: function () {
      this.dialog = this.open;
      if (this.$refs.form) {
        this.$refs.form.resetValidation();
      }
      this.loading = false;
    },
  },
  methods: {
    resetValidation() {
      if (this.$refs.form) {
        this.$refs.form.resetValidation();
      }
    },
    commissionStyle(name, type) {
      let value = '';
      this.commission_style.forEach((item) => {
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
    accessStyle(name, type) {
      let value = '';
      this.access_style.forEach((item) => {
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
    addAccess() {
      if (this.$refs.form.validate()) {
        this.loading = true;
        this.item.accesses.accesses = this.item.access;
        this.item.accesses.commissions = this.item.commission;
        this.$emit('addAccess', this.item);
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
    dark_theme() {
      try {
        return this.$store.state.user.configs.theme == 0;
      } catch (err) {
        return false;
      }
    },
    defaultItem() {
      return {
        user_id: this.$store.state.user.id,
        name: '',
        accesses: { accesses: '', commissions: '' },
        access: '',
        commission: '',
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