<template>
  <div>
    <v-dialog v-model="dialog" persistent max-width="700">
      <v-card :loading="loading">
        <div
          id="attachMenu"
          style="width: 290px; position: absolute; right: 60px; top: 95px"
        ></div>
        <template slot="progress">
          <v-progress-linear
            :color="color"
            height="10"
            indeterminate
          ></v-progress-linear>
        </template>
        <v-card-title class="title-modal" v-if="!loading">
          <strong>Gerar Relatório</strong>
          <v-spacer></v-spacer>
          <img width="30" src="../../assets/images/sicoobicon.png" />
        </v-card-title>
        <v-card-title class="title-modal" v-else>
          <strong>Gerando Relatório</strong>
          <v-spacer></v-spacer>
          <img width="50" src="../../assets/images/loading.gif" />
        </v-card-title>
        <v-card-subtitle v-if="!loading" class="pt-4">
          <span class="bold">Deixe os filtros vazios para selecionar tudo</span>
        </v-card-subtitle>
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
          <v-form ref="form" v-model="valid" class="ma-3" lazy-validation>
            <v-row>
              <v-col cols="12">
                <v-autocomplete
                  label="Produtos"
                  :color="color"
                  prepend-icon="mdi-storefront"
                  placeholder="Enter para confirmar (Deixe vazio para pegar todos os produtos)"
                  v-model="item.products"
                  :items="products"
                  auto-select-first
                  solo
                  clearable
                  small-chips
                  multiple
                  deletable-chips
                >
                  <template v-slot:no-data>
                    <div class="px-4">
                      <span
                        style="
                          font-family: 'Quicksand', sans-serif;
                          font-weight: bold;
                        "
                        >Falha ao carregar produtos</span
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
                        <span>Não existem produtos com essa filtragem</span>
                      </v-tooltip>
                    </div>
                  </template>
                </v-autocomplete>
              </v-col>
              <v-col cols="12">
                <v-autocomplete
                  label="Usuários"
                  :color="color"
                  prepend-icon="mdi-account"
                  placeholder="Enter para confirmar (Deixe vazio para pegar todos os usuários)"
                  v-model="item.users"
                  :items="users"
                  :loading="loading_users"
                  auto-select-first
                  item-text="full_name"
                  item-value="id"
                  solo
                  clearable
                  small-chips
                  multiple
                  deletable-chips
                >
                  <template v-slot:selection="item">
                    <v-chip
                      v-bind="item.attrs"
                      :input-value="item.selected"
                      close
                      @click="item.select"
                      @click:close="remove(item.item)"
                    >
                      <v-avatar left>
                        <v-img
                          v-if="!item.item.photo"
                          :src="
                            require(`./../../assets/icons/${
                              item.item.gender == 1 ? 'man.png' : 'woman.png'
                            }`)
                          "
                        ></v-img>
                        <v-img v-else :src="require(item.item.photo)"></v-img>
                      </v-avatar>
                      {{
                        abreviateString(
                          item.item.full_name,
                          item.item.name,
                          '',
                          true
                        )
                      }}
                    </v-chip>
                  </template>
                  <template v-slot:item="item">
                    <v-list-item-avatar>
                      <v-img
                        v-if="!item.item.photo"
                        :src="
                          require(`./../../assets/icons/${
                            item.item.gender == 1 ? 'man.png' : 'woman.png'
                          }`)
                        "
                      ></v-img>
                      <v-img v-else :src="require(item.item.photo)"></v-img>
                    </v-list-item-avatar>
                    <v-list-item-content>
                      <v-list-item-title
                        v-html="item.item.full_name"
                      ></v-list-item-title>
                      <v-list-item-subtitle
                        v-html="item.item.role"
                      ></v-list-item-subtitle>
                    </v-list-item-content>
                  </template>
                  <template v-slot:no-data>
                    <div class="px-4">
                      <span
                        style="
                          font-family: 'Quicksand', sans-serif;
                          font-weight: bold;
                        "
                        >Nenhum usuário encontrado</span
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
                          filtro), houve um erro de rede. Certifique-se de sua
                          conexão e atualize a página</span
                        >
                      </v-tooltip>
                    </div>
                  </template>
                </v-autocomplete>
              </v-col>

              <v-col cols="12">
                <v-menu
                  attach="#attachMenu"
                  open-on-hover
                  :close-on-content-click="false"
                  :nudge-width="200"
                  max-width="290"
                  :color="color"
                  top
                  offset-y
                >
                  <template v-slot:activator="{ on }">
                    <v-text-field
                      v-model="dateRangeText"
                      v-bind="$attrs"
                      v-on="on"
                      label="Filtre por um dia ou por um período"
                      append-icon="mdi-close"
                      prepend-icon="mdi-calendar"
                      readonly
                      solo
                      @click:append="item.dates = []"
                    ></v-text-field>
                  </template>
                  <template>
                    <v-date-picker
                      locale="pt-BR"
                      :color="color"
                      elevation="9"
                      @change="changeDateFilter"
                      v-model="item.dates"
                      :selectedItemsText="dateTitleText"
                      range
                    ></v-date-picker>
                  </template>
                </v-menu>
              </v-col>
              <v-col cols="12">
                <v-autocomplete
                  :menu-props="{ offsetY: true }"
                  solo
                  :items="status"
                  :color="color"
                  label="Status"
                  v-model="item.status"
                  placeholder="Enter para confirmar (Deixe vazio para pegar todos os status)"
                  prepend-icon="mdi-clock"
                  auto-select-first
                  clearable
                  small-chips
                  multiple
                  deletable-chips
                >
                  <template v-slot:no-data>
                    <div class="px-4">
                      <span
                        style="
                          font-family: 'Quicksand', sans-serif;
                          font-weight: bold;
                        "
                        >Falha ao carregar status</span
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
                        <span>Não existem status com essa filtragem</span>
                      </v-tooltip>
                    </div>
                  </template>
                  <template v-slot:selection="{ item }">
                    <div
                      :class="
                        'small-chip gradient-' + statusStyle(item, 'gradient')
                      "
                    >
                      <div class="chip__content">
                        <v-icon color="white">{{
                          statusStyle(item, 'icon')
                        }}</v-icon>
                      </div>
                    </div>
                  </template>
                  <template v-slot:item="{ item }">
                    <div
                      :class="'chip gradient-' + statusStyle(item, 'gradient')"
                    >
                      <div class="chip__content">
                        <v-icon :color="statusStyle(item, 'color')">{{
                          statusStyle(item, 'icon')
                        }}</v-icon>
                        <span class="item-select-badge">{{ item }}</span>
                      </div>
                    </div>
                  </template>
                </v-autocomplete>
              </v-col>
            </v-row>
          </v-form>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions v-if="!loading">
          <v-btn color="red darken-1" dark text @click="closeModal()">
            Cancelar
          </v-btn>
          <v-spacer></v-spacer>
          <v-btn
            :color="color"
            :disabled="!valid"
            icon
            @click="loadReportData(1)"
          >
            <v-img width="40" src="./../../assets/icons/xls.png"></v-img>
          </v-btn>
          <v-btn
            :color="color"
            :disabled="!valid"
            icon
            @click="loadReportData(2)"
          >
            <v-img width="40" src="./../../assets/icons/pdf.png"></v-img>
          </v-btn>
        </v-card-actions>
      </v-card>
      <download-excel
        v-show="false"
        id="report_commission_excel"
        :data="items_computed"
        name="Relatório_Comissões.xls"
        header="Relatório das Comissões"
        :fields="fields_excel_report"
        :footer="[
          '--Fim dos Registros--',
          'Filtro Aplicado:',
          'Usuários: ' + (item.users.length > 0 ? users_name : 'TODOS'),
          'Produtos: ' + (item.products.length > 0 ? item.products : 'TODOS'),
          'Status: ' + (item.status.length > 0 ? item.status : 'TODOS'),
          'Requisitado em: ' + new Date().toLocaleString(),
          'Sicoob Credisg Software - v.1.0.0',
        ]"
        default-value="Não informado"
        worksheet="Relatório das Comissões"
      >
      </download-excel>
    </v-dialog>
  </div>
</template>

<script>
export default {
  props: ['open', 'commissions'],
  components: {},
  data() {
    return {
      color: 'blue',
      valid: true,
      dialog: false,
      dialog_date: false,
      loading: false,
      loading_users: false,
      users: [],
      item: {
        products: [],
        users: [],
        dates: [],
        status: ['Aprovado UPS'],
      },
      items: [],
      items_computed: [],
      products: [
        'Seguro de Vida - Sicoob Seguradora',
        'Seguro de Vida',
        'Seguro de Vida Coletivo',
        'Seguro Auto',
        'Seguro Residencial e Empresarial',
        'Seguro Agrícola',
        'Seguro Animal de Elite',
        'Seguro Equipamentos',
        'Seguro Prestamista',
        'Crédito Consignado',
        'Consórcio',
      ],
      fields_excel_report: {
        Produto: 'product',
        'Valor (R$)': {
          field: 'value',
          callback: (value) => {
            return `R$ ${value}`;
          },
        },
        Status: 'status',
        Indicador: 'indicator.full_name',
        Vendedor: 'seller.full_name',
        Operador: 'operator.full_name',
        'Valor Prestamista (R$)': {
          field: 'custom_value',
          callback: (value) => {
            return `R$ ${value}`;
          },
        },
        'Comissão Cooperativa (%)': {
          field: 'commission_percentage',
          callback: (value) => {
            return `${value}%`;
          },
        },
        'Comissão Indicador (R$)': {
          field: 'indicator_commission',
          callback: (value) => {
            return `R$ ${value}`;
          },
        },
        'Comissão Vendedor (R$)': {
          field: 'seller_commission',
          callback: (value) => {
            return `R$ ${value}`;
          },
        },
        'Comissão Operador (R$)': {
          field: 'operator_commission',
          callback: (value) => {
            return `R$ ${value}`;
          },
        },
        'Data da Indicação': 'date_indicator',
        'Data da Venda': 'date_seller',
        'Data da Operação': 'date_operator',
        'Inserido por:': 'user.full_name',
        'Às:': {
          field: 'created_at',
          callback: (value) => {
            return value.slice(0, 19).replace(/T/i, ' ').replace(/-/, '/');
          },
        },
        'Última edição:': {
          field: 'updated_at',
          callback: (value) => {
            return value.slice(0, 19).replace(/T/i, ' ').replace(/-/, '/');
          },
        },
      },
      status_style: [
        {
          status: 'Aguard. Venda',
          color: '#5b75dc',
          icon: 'mdi-store-clock-outline',
          gradient: 'blue',
        },
        {
          status: 'Não Vendido',
          color: '#5f6e8b',
          icon: 'mdi-store-remove-outline',
          gradient: 'gray',
        },
        {
          status: 'Aguard. UPS',
          color: 'orange darken-3',
          icon: 'mdi-account-tie',
          gradient: 'orange',
        },
        {
          status: 'Aprovado UPS',
          color: 'blue darken-1',
          icon: 'mdi-check-outline',
          gradient: 'success',
        },
        {
          status: 'Recusado UPS',
          color: 'red lighten-5',
          icon: 'mdi-close-outline',
          gradient: 'error',
        },
      ],
      status: [
        'Aguard. Venda',
        'Não Vendido',
        'Aguard. UPS',
        'Aprovado UPS',
        'Recusado UPS',
      ],
      /* RULES */
    };
  },
  watch: {
    item: function () {
      console.log(this.item);
    },
    open: function () {
      this.dialog = this.open;
      if (this.dialog) {
        this.items = this.commissions;
        Object.assign(this.item, this.defaultItem);
        this.getUsers();
      } else {
        this.items = [];
        this.items_computed = [];
        if (this.$refs.form) {
          this.$refs.form.resetValidation();
        }
        this.loading = false;
      }
    },
  },
  methods: {
    formatDate(date, y = true) {
      let day_month = date.slice(5, 10);
      let day = day_month.slice(3);
      let month = day_month.slice(0, 2);
      let year = date.slice(0, 4);
      return y ? day + '/' + month + '/' + year : day + '/' + month;
    },
    formatDateRange(dates, year = true) {
      if (dates.length < 2) {
        if (dates.length) {
          return this.formatDate(dates[0]);
        } else {
          return '';
        }
      }
      let first_date = this.formatDate(new String(dates[0]), year);
      let second_date = this.formatDate(new String(dates[1]), year);
      let date_range = first_date + ' ~ ' + second_date;

      return date_range;
    },
    changeDateFilter(value) {
      if (value.length > 1 && value[0] == value[1]) {
        this.item.dates = this.item.dates.splice(1);
      }
    },
    statusStyle(status, type) {
      let value = '';
      this.status_style.forEach((item) => {
        if (item.status == status) {
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
    abreviateString(
      str,
      prefix = '',
      suffix = '',
      delete_first = false,
      space_p = true,
      space_s = true
    ) {
      let initials = str.match(/\b\w/g).join('. ') + '.';
      if (delete_first) {
        initials = initials.substr(initials.indexOf(' ') + 1);
      }
      return (
        prefix + (space_p ? ' ' : '') + initials + (space_s ? ' ' : '') + suffix
      );
    },
    remove(item) {
      const index = this.item.users.indexOf(item.id);
      if (index >= 0) this.item.users.splice(index, 1);
    },
    getUsers() {
      this.loading_users = true;
      this.$http
        .post('get_users', {
          select: ['id', 'full_name', 'name', 'photo', 'gender'],
        })
        .then((response) => {
          this.users = response.data;
          this.loading_users = false;
        });
    },
    loadReportData(type) {
      if (this.$refs.form.validate()) {
        this.loading = true;
        let filter_user = true;
        let filter_product = true;
        let filter_status = true;
        filter_user = this.item.users.length != 0;
        filter_product = this.item.products.length != 0;
        filter_status = this.item.status.length != 0;
        this.filterReportData(filter_product, filter_user, filter_status);
        Object.assign(this.items_computed, this.items);
        if (type == 1) {
          let excel_button = document.getElementById('report_commission_excel');
          excel_button.click();
        } else {
          console.log(1);
        }

        this.closeModal();
      }
    },
    filterReportData(filter_product, filter_user, filter_status) {
      if (filter_user) {
        this.items = this.items.filter((commission) => {
          return (
            this.item.users.includes(commission.indicator_id) ||
            this.item.users.includes(commission.seller_id) ||
            this.item.users.includes(commission.operator_id)
          );
        });
      }
      if (filter_product) {
        this.items = this.items.filter((commission) => {
          return this.item.products.includes(commission.product);
        });
      }
      if (filter_status) {
        this.items = this.items.filter((commission) => {
          return this.item.status.includes(commission.status);
        });
      }
    },
    closeModal() {
      this.$emit('closeModal');
    },
  },
  computed: {
    getTitleDateFormat(isoDate) {
      let date = '';
      if (this.item.dates.length > 1) {
        date = isoDate;
      }
      return date;
    },
    dateRangeText() {
      return this.formatDateRange(this.item.dates);
    },
    dateTitleText() {
      return this.formatDateRange(this.item.dates, false);
    },
    users_name() {
      let users = this.users.filter((user) => {
        return this.item.users.includes(user.id);
      });
      return users.map((user) => {
        return user.full_name;
      });
    },
    defaultItem() {
      return {
        products: [],
        users: [],
        dates: [],
        status: ['Aprovado UPS'],
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