<template>
  <div>
    <v-dialog v-model="dialog" persistent max-width="700">
      <v-card :loading="loading">
        <template slot="progress">
          <v-progress-linear
            :color="color"
            height="10"
            indeterminate
          ></v-progress-linear>
        </template>
        <v-card-title class="title-modal" v-if="!loading">
          <strong>Editar Comissão</strong>
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
              <v-col cols="12" sm="6">
                <v-select
                  :items="products"
                  :rules="requiredRule"
                  :color="color"
                  label="Produto"
                  :disabled="!accesses('product')"
                  @change="changeProduct"
                  v-model="item.product"
                  prepend-icon="mdi-storefront"
                ></v-select>
              </v-col>

              <v-col cols="12" sm="6">
                <v-select
                  :menu-props="{ offsetY: true }"
                  solo
                  :disabled="!accesses('status')"
                  :items="status()"
                  :color="color"
                  :rules="requiredRule"
                  label="Status"
                  @change="changeStatus()"
                  v-model="item.status"
                  prepend-icon="mdi-clock"
                >
                  <template v-slot:selection="{ item }">
                    <div
                      :class="'chip gradient-' + statusStyle(item, 'gradient')"
                    >
                      <div class="chip__content">
                        <v-icon :color="statusStyle(item, 'color')">{{
                          statusStyle(item, "icon")
                        }}</v-icon>
                        <span class="item-select-badge">{{ item }}</span>
                      </div>
                    </div>
                  </template>
                  <template v-slot:item="{ item }">
                    <div
                      :class="'chip gradient-' + statusStyle(item, 'gradient')"
                    >
                      <div class="chip__content">
                        <v-icon :color="statusStyle(item, 'color')">{{
                          statusStyle(item, "icon")
                        }}</v-icon>
                        <span class="item-select-badge">{{ item }}</span>
                      </div>
                    </div>
                  </template>
                </v-select>
              </v-col>
            </v-row>
            <v-row align="center" v-if="accesses('indicator')">
              <v-col cols="12" sm="6">
                <v-autocomplete
                  class="px-3"
                  label="Indicador"
                  :color="color"
                  prepend-icon="mdi-bullhorn-outline"
                  :rules="requiredRule"
                  placeholder="Enter para confirmar"
                  v-model="item.indicator_id"
                  :items="users"
                  :loading="loading_users"
                  auto-select-first
                  item-text="full_name"
                  item-value="id"
                  solo
                >
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
              <v-col cols="12" md="6">
                <DateTimePicker
                  label="Data/Hora da Indicação"
                  :updateComponent="update_datetime_picker"
                  @resetValidation="resetValidation"
                  v-model="item.date_indicator"
                  :color="color"
                  clearable
                ></DateTimePicker>
              </v-col>
            </v-row>
            <div v-if="accesses('seller')">
              <v-divider></v-divider>
              <br />
              <v-row align="center">
                <v-col cols="12" md="6">
                  <v-autocomplete
                    :disabled="accesses('disableSeller')"
                    class="px-3"
                    label="Vendedor"
                    :color="color"
                    prepend-icon="mdi-account-tie-voice"
                    :rules="sellerRule"
                    placeholder="Enter para confirmar"
                    v-model="item.seller_id"
                    :items="users"
                    :loading="loading_users"
                    auto-select-first
                    item-text="full_name"
                    item-value="id"
                    solo
                  >
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
                          <span>{{ no_users }}</span>
                        </v-tooltip>
                      </div>
                    </template>
                  </v-autocomplete>
                </v-col>
                <v-col cols="12" md="6">
                  <DateTimePicker
                    label="Data/Hora da Venda"
                    :disabled="accesses('disableSeller')"
                    :updateComponent="update_datetime_picker_seller"
                    @resetValidation="resetValidation"
                    :rules="requiredSellerRule"
                    v-model="item.date_seller"
                    :color="color"
                    clearable
                  ></DateTimePicker>
                </v-col>
              </v-row>
              <v-row align="center">
                <v-col cols="12" md="6">
                  <v-text-field-money
                    label="Valor (R$)"
                    v-bind:properties="{
                      prependIcon: 'mdi-cash',
                      color: color,
                      class: 'px-3',
                      disabled: accesses('disableSeller'),
                      rules: valueRule,
                      placeholder: 'Valor efetivo do produto',
                      outlined: true,
                      suffix: 'R$',
                    }"
                    v-model="item.value"
                  ></v-text-field-money>
                </v-col>
                <v-col cols="12" md="6">
                  <vuetify-number
                    v-model="item.commission_percentage"
                    v-bind:label="'Comissão da Cooperativa (%)'"
                    v-bind:readonly="
                      item.product == 'Seguro Prestamista' ||
                      item.product == 'Seguro de Vida - Sicoob Seguradora' ||
                      item.product == 'Consórcio'
                    "
                    v-bind:disabled="accesses('disableSeller')"
                    v-bind:outlined="true"
                    v-bind:rules="requiredSellerRule"
                    v-bind:color="color"
                    v-bind:valueWhenIsEmpty="null"
                    v-bind:options="options"
                  />
                </v-col>
              </v-row>
              <v-row align="center" v-if="item.product == 'Seguro Prestamista'">
                <v-col cols="12" md="6">
                  <v-text-field-money
                    label="Valor a ser Comissionado (R$)"
                    v-bind:properties="{
                      prependIcon: 'mdi-cash',
                      color: color,
                      class: 'px-3',
                      disabled: accesses('disableSeller'),
                      rules: valueRule,
                      placeholder: 'Valor efetivo a ser comissionado',
                      outlined: true,
                      suffix: 'R$',
                    }"
                    v-model="item.custom_value"
                  ></v-text-field-money>
                </v-col>
              </v-row>
            </div>
            <div v-if="accesses('operator')">
              <v-divider></v-divider>
              <br />
              <v-row align="center">
                <v-col cols="12" md="6">
                  <v-autocomplete
                    class="px-3"
                    label="Operador"
                    :color="color"
                    prepend-icon="mdi-account-tie"
                    :rules="operatorRule"
                    placeholder="Enter para confirmar"
                    v-model="item.operator_id"
                    :items="users"
                    :disabled="accesses('disableOperator')"
                    :loading="loading_users"
                    auto-select-first
                    item-text="full_name"
                    item-value="id"
                    solo
                  >
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
                          <span>{{ no_users }}</span>
                        </v-tooltip>
                      </div>
                    </template>
                  </v-autocomplete>
                </v-col>
                <v-col cols="12" md="6">
                  <DateTimePicker
                    label="Data/Hora da Operação"
                    :updateComponent="update_datetime_picker_operator"
                    @resetValidation="resetValidation"
                    v-model="item.date_operator"
                    :disabled="accesses('disableOperator')"
                    :rules="requiredOperatorRule"
                    :color="color"
                    clearable
                  ></DateTimePicker>
                </v-col>
              </v-row>
            </div>
          </v-form>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions v-if="!loading">
          <v-spacer></v-spacer>
          <v-btn color="red darken-1" dark text @click="closeModal()">
            Cancelar
          </v-btn>
          <v-btn :color="color" text @click="editCommission()"> Salvar </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import DateTimePicker from "../util/DateTimePicker.vue";
export default {
  props: ["open", "commission"],
  components: { DateTimePicker },
  data() {
    return {
      color: "orange",
      valid: true,
      dialog: false,
      loading: false,
      loading_users: false,
      update_datetime_picker: false,
      update_datetime_picker_operator: false,
      update_datetime_picker_seller: false,
      users: [],
      no_users:
        "Se existem usuários cadastrados (considerando o filtro), houve um erro de rede. Certifique-se de sua conexão e atualize a página",
      item: {
        user_id: "",
        date_indicator: "",
        date_seller: "",
        date_operator: "",
        product: "",
        value: "",
        custom_value: "",
        commission_percentage: "",
        indicator_id: "",
        seller_id: "",
        operator_id: "",
        status: "",
        indicator_commission: "",
        seller_commission: "",
        operator_commission: "",
      },
      options: {
        locale: "pt-BR",
        prefix: "",
        suffix: "%",
        length: 4,
        precision: 2,
        prepend_icon: "mdi-cash-100",
        color: this.color,
      },
      products: [
        "Seguro de Vida - Sicoob Seguradora",
        "Seguro de Vida",
        "Seguro de Vida Coletivo",
        "Seguro Auto",
        "Seguro Residencial e Empresarial",
        "Seguro Agrícola",
        "Seguro Animal de Elite",
        "Seguro Equipamentos",
        "Seguro Prestamista",
        "Crédito Consignado",
        "Consórcio",
      ],
      status_style: [
        {
          status: "Aguard. Venda",
          color: "#5b75dc",
          icon: "mdi-store-clock-outline",
          gradient: "blue",
        },
        {
          status: "Não Vendido",
          color: "#5f6e8b",
          icon: "mdi-store-remove-outline",
          gradient: "gray",
        },
        {
          status: "Aguard. UPS",
          color: "orange darken-3",
          icon: "mdi-account-tie",
          gradient: "orange",
        },
        {
          status: "Aprovado UPS",
          color: "blue darken-1",
          icon: "mdi-check-outline",
          gradient: "success",
        },
        {
          status: "Recusado UPS",
          color: "red lighten-5",
          icon: "mdi-close-outline",
          gradient: "error",
        },
      ],
      /* RULES */
      requiredRule: [(v) => !!v || "Essa informação é obrigatória"],
      requiredSellerRule: [
        (v) =>
          !!v ||
          this.item.status == "Aguard. Venda" ||
          this.item.status == "Não Vendido" ||
          this.item.status == "" ||
          "O status selecionado indica que a venda ocorreu, então essa informação é obrigatória",
      ],
      requiredOperatorRule: [
        (v) =>
          !!v ||
          (this.item.status != "Recusado UPS" &&
            this.item.status != "Aprovado UPS") ||
          "O status selecionado indica que a UPS avaliou esta venda, então essa informação é obrigatória",
      ],
      valueRule: [
        (v) =>
          (!!v &&
            (parseFloat(this.item.value) > 0 || "O valor não pode ser 0")) ||
          this.item.status == "Aguard. Venda" ||
          this.item.status == "Não Vendido" ||
          this.item.status == "" ||
          "O status selecionado indica que a venda foi feita, então essa informação é obrigatória",
      ],
      sellerRule: [
        (v) =>
          (!!v &&
            (this.item.seller_id != this.item.operator_id ||
              "O vendedor e o operador devem ser distintos")) ||
          this.item.status == "Aguard. Venda" ||
          this.item.status == "" ||
          "O status selecionado indica que a venda foi feita ou houve contato com o cliente, então essa informação é obrigatória",
      ],
      operatorRule: [
        (v) =>
          (!!v &&
            (this.item.operator_id != this.item.seller_id ||
              "O operador e o vendedor devem ser distintos")) ||
          (this.item.status != "Recusado UPS" &&
            this.item.status != "Aprovado UPS") ||
          "O status selecionado indica que a UPS avaliou esta venda, então essa informação é obrigatória",
      ],
    };
  },
  watch: {
    open: function () {
      this.dialog = this.open;
      this.update_datetime_picker = this.dialog;
      this.update_datetime_picker_seller = this.dialog;
      this.update_datetime_picker_operator = this.dialog;
      this.loading = false;
      this.resetValidation();
      if (this.dialog) {
        this.get_users();
      }
    },
    commission: function () {
      Object.assign(
        Object.assign(this.item, this.defaultItem),
        this.commission
      );
      if (this.$refs.form) {
        this.$refs.form.resetValidation();
      }
    },
  },
  methods: {
    get_users() {
      this.loading_users = true;
      this.$http
        .post("get_users", { select: ["id", "full_name"] })
        .then((response) => {
          this.users = response.data;
          this.loading_users = false;
        });
    },
    resetValidation() {
      if (this.$refs.form) {
        this.$refs.form.resetValidation();
      }
    },
    accesses(type) {
      switch (type) {
        case "product":
          if (this.$store.state.user.accesses.commissions == "indicator") {
            return (
              this.item.user_id == this.$store.state.user.id &&
              this.item.status == "Aguard. Venda"
            );
          } else if (this.$store.state.user.accesses.commissions == "seller") {
            return (
              this.item.status != "Recusado UPS" &&
              this.item.status != "Aceito UPS"
            );
          } else {
            return true;
          }
        case "status":
          if (this.$store.state.user.accesses.commissions == "indicator") {
            return false;
          } else if (this.$store.state.user.accesses.commissions == "seller") {
            return (
              this.item.status != "Recusado UPS" &&
              this.item.status != "Aceito UPS"
            );
          } else {
            return true;
          }
        case "disableSeller":
          return this.item.status == "Aguard. Venda";
        case "disableOperator":
          return (
            this.item.status != "Aprovado UPS" &&
            this.item.status != "Recusado UPS"
          );
        case "indicator":
          return (
            this.$store.state.user.accesses.commissions == "operator" ||
            this.item.user_id == this.$store.state.user.id
          );
        case "seller":
          return (
            this.$store.state.user.accesses.commissions == "operator" ||
            (this.$store.state.user.accesses.commissions == "seller" &&
              this.item.status != "Recusado UPS" &&
              this.item.status != "Aprovado UPS")
          );
        case "operator":
          return this.$store.state.user.accesses.commissions == "operator";
        default:
          return false;
      }
    },
    /*
    accesses(type) {
      switch (type) {
        case "product":
          if (this.$store.state.user.accesses.commissions == "indicator") {
            return (
              this.item.user_id == this.$store.state.user.id &&
              this.item.status == "Aguard. Venda"
            );
          } else if (this.$store.state.user.accesses.commissions == "seller") {
            return (
              this.item.user_id == this.$store.state.user.id &&
              this.item.status != "Recusado UPS" &&
              this.item.status != "Aceito UPS"
            );
          } else {
            return true;
          }
        case "status":
          if (this.$store.state.user.accesses.commissions == "indicator") {
            return false;
          } else if (this.$store.state.user.accesses.commissions == "seller") {
            return (
              !this.item.seller_id ||
              ((this.item.user_id == this.$store.state.user.id ||
                this.item.seller_id == this.$store.state.user.id) &&
                this.item.status != "Recusado UPS" &&
                this.item.status != "Aceito UPS")
            );
          } else {
            return true;
          }
        case "indicator":
          return (
            this.$store.state.user.accesses.commissions == "operator" ||
            this.item.user_id == this.$store.state.user.id
          );
        case "seller":
          return (
            this.$store.state.user.accesses.commissions == "operator" ||
            (this.$store.state.user.accesses.commissions == "seller" &&
              (!this.item.seller_id ||
                this.item.seller_id == this.$store.state.user.id ||
                this.item.user_id == this.$store.state.user.id) &&
              this.item.status != "Recusado UPS" &&
              this.item.status != "Aprovado UPS")
          );
        case "operator":
          return this.$store.state.user.accesses.commissions == "operator";
        default:
          return false;
      }
    },
    */
    changeStatus() {
      if (this.item.status == "Aguard. Venda") {
        this.update_datetime_picker_seller = false;
        this.update_datetime_picker_operator = false;
        this.item.seller_id =
          this.item.custom_value =
          this.item.date_seller =
          this.item.value =
            "";
        if (
          this.item.product !== "Seguro Prestamista" &&
          this.item.product !== "Seguro de Vida - Sicoob Seguradora" &&
          this.item.product !== "Consórcio"
        ) {
          this.item.commission_percentage = "";
        }
      } else if (
        this.item.status != "Aprovado UPS" &&
        this.item.status != "Recusado UPS"
      ) {
        this.update_datetime_picker_seller = true;
        this.update_datetime_picker_operator = false;
        this.item.operator_id = this.item.date_operator = "";
      } else {
        this.update_datetime_picker_seller = true;
        this.update_datetime_picker_operator = true;
      }
      this.$refs.form.resetValidation();
    },
    changeProduct(item) {
      switch (item) {
        case "Seguro Prestamista":
          this.item.custom_value = "";
          this.item.commission_percentage = "40.00";
          break;
        case "Seguro de Vida - Sicoob Seguradora":
          this.item.custom_value = "";
          this.item.commission_percentage = "30.00";
          break;
        case "Consórcio":
          this.item.custom_value = "";
          this.item.commission_percentage = "3.00";
          break;
        default:
          this.item.custom_value = "";
          this.item.commission_percentage = "";
          break;
      }
    },
    status() {
      switch (this.$store.state.user.accesses.commissions) {
        case "indicator":
          this.item.status = "Aguard. Venda";
          return ["Aguard. Venda"];
        case "seller":
          return ["Aguard. Venda", "Não Vendido", "Aguard. UPS"];
        case "operator":
          return [
            "Aguard. Venda",
            "Não Vendido",
            "Aguard. UPS",
            "Aprovado UPS",
            "Recusado UPS",
          ];
      }
    },
    statusStyle(status, type) {
      let value = "";
      this.status_style.forEach((item) => {
        if (item.status == status) {
          if (type == "color") {
            value = item.color;
          } else if (type == "icon") {
            value = item.icon;
          } else {
            value = item.gradient;
          }
        }
      });
      return value;
    },
    editCommission() {
      if (this.$refs.form.validate()) {
        this.loading = true;
        this.$emit("editCommission", this.item);
        Object.assign(this.item, this.defaultItem);
      }
    },
    closeModal() {
      this.$emit("closeEditModal");
      Object.assign(this.item, this.defaultItem);
    },
  },
  computed: {
    defaultItem() {
      return {
        user_id: "",
        date_indicator: "",
        date_seller: "",
        date_operator: "",
        product: "",
        value: "",
        custom_value: "",
        commission_percentage: "",
        indicator_id: "",
        seller_id: "",
        operator_id: "",
        status: "",
        indicator_commission: "",
        seller_commission: "",
        operator_commission: "",
      };
    },
  },
};
</script>

<style scoped>
.title-modal {
  font-family: "Quicksand", sans-serif;
  color: orange;
}
.item-select-badge {
  font-family: "Quicksand", sans-serif;
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
.v-select__selection {
  display: flex !important;
  width: 100% !important;
  align-content: center !important;
  align-items: center !important;
  justify-content: center !important;
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