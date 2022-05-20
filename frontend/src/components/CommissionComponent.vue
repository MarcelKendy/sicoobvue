
<template>
  <div>
    <div class="tooltip" style="padding-bottom: 15px; font-weight: 700">
      <v-btn
        rounded
        elevation="9"
        :color="!dark_theme ? 'rgb(36, 0, 121)' : 'yellow lighten-2'"
        :dark="!dark_theme"
        @click="dark_theme = !dark_theme"
        small
      >
        <span class="second_font-bold">Tema</span>
        <v-icon dark right>
          {{ !dark_theme ? "mdi-weather-night" : "mdi-white-balance-sunny" }}
        </v-icon>
      </v-btn>
      <span class="tooltiptext">{{
        !this.dark_theme
          ? 'Mudar o tema de cores para "dark"'
          : 'Mudar o tema de cores para "light"'
      }}</span>
    </div>

    <v-tooltip left>
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          small
          fixed
          right
          color="rgb(0, 209, 94)"
          dark
          fab
          v-bind="attrs"
          v-on="on"
          @click="addModal()"
        >
          <v-icon> mdi-plus </v-icon>
        </v-btn>
      </template>
      <span>Adicionar</span>
    </v-tooltip>

    <v-card class="hover-card" outlined shaped>
      <v-card-title :class="dark_theme ? 'title-card-dark' : 'title-card'">
        <span>Produtos e Comissões</span>

        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Pesquisar"
          :dark="dark_theme"
          single-line
          color="rgba(18,210,175)"
        ></v-text-field>
      </v-card-title>
      <v-data-table
        style="font-weight: bolder"
        :dark="dark_theme"
        class="data-table-commission"
        :loading="loading_commissions"
        :headers="headers"
        :items="items"
        :search="search"
        :sort-by="['date_indicator', 'value']"
        multi-sort
        show-expand
        :expanded.sync="expanded"
        :footerProps="{
          itemsPerPageText: 'Vendas por página:',
          itemsPerPageOptions: [10, 30, 50, 100],
        }"
        no-data-text="Nenhum dado inserido"
        :headerProps="{ sortByText: 'Ordenar Por:' }"
        no-results-text="Não há nenhum registro acerca da pesquisa informada"
        loading-text="Carregando..."
      >
        <template v-slot:[`footer.page-text`]="items">
          {{ items.pageStart }} até {{ items.pageStop }} - Total:
          <strong>{{ items.itemsLength }}</strong>
        </template>
        <template v-slot:expanded-item="{ headers, item }">
          <td :colspan="headers.length" v-if="item.status == 'Aprovado UPS'">
            <v-card class="ma-3">
              <v-card-text>
                <strong>
                  <span class="ma-2">
                    <strong class="blue--text text--darken-3">
                      Comissões dos empregados referentes ao produto "
                      {{ item.product }}":
                    </strong>
                    <span style="font-size: 13px; padding-left: 10px">
                      (Comissão da <span class="green--text">cooperativa </span>
                      <v-img
                        style="display: inline-block"
                        max-width="15px"
                        alt="Sicoob"
                        src="../assets/images/sicoobicon.png"
                      ></v-img>
                      :
                      <span class="text-decoration-underline"
                        >{{ item.commission_percentage }}%)
                      </span>
                    </span>
                    <v-tooltip left>
                      <template v-slot:activator="{ on, attrs }">
                        <v-btn
                          v-bind="attrs"
                          v-on="on"
                          icon
                          @click="show_math = true"
                          style="position: absolute; top: 0; right: 0"
                        >
                          <v-icon>mdi-calculator</v-icon>
                        </v-btn>
                      </template>
                      <span>Mostrar Cálculo</span>
                    </v-tooltip>
                  </span>
                  <br v-if="item.custom_value" />
                  <span v-if="item.custom_value" class="ma-2">
                    <span class="blue--text">Valor comissionado:</span>
                    <span> R$ {{ item.custom_value }}</span>
                  </span>
                  <br />
                  <span v-html="commissionPrint(item)"></span>
                </strong>
              </v-card-text>
            </v-card>
          </td>
          <td :colspan="headers.length" v-else>
            <v-card class="ma-3 text-center">
              <v-card-text>
                <strong>
                  <span class="yellow--text text--darken-2">
                    <span>{{
                      item.status == "Recusado UPS"
                        ? "A UPS REPROVOU esta venda"
                        : item.status == "Aguard. UPS"
                        ? "A UPS ainda não aprovou a venda"
                        : "Esse produto ainda não foi vendido"
                    }}</span>
                  </span>
                </strong>
              </v-card-text>
            </v-card>
          </td>
        </template>

        <template v-slot:[`item.date_indicator`]="{ item }">
          <v-chip color="blue-grey lighten-2" small>
            <v-tooltip left v-if="!item.date_seller && !item.date_operator">
              <template v-slot:activator="{ on, attrs }">
                <span v-bind="attrs" v-on="on">
                  {{ formatDate(item.date_indicator, "d_m") }}
                </span>
              </template>
              <span>{{ formatDate(item.date_indicator, "y") }}</span>
            </v-tooltip>
            <v-tooltip left v-else-if="!item.date_operator">
              <template v-slot:activator="{ on, attrs }">
                <span v-bind="attrs" v-on="on">
                  {{ formatDate(item.date_seller, "d_m") }}
                </span>
              </template>
              <span>{{ formatDate(item.date_seller, "y") }}</span>
            </v-tooltip>
            <v-tooltip left v-else>
              <template v-slot:activator="{ on, attrs }">
                <span v-bind="attrs" v-on="on">
                  {{ formatDate(item.date_operator, "d_m") }}
                </span>
              </template>
              <span>{{ formatDate(item.date_operator, "y") }}</span>
            </v-tooltip>
          </v-chip>
        </template>
        <template v-slot:[`item.product`]="{ item }">
          <v-tooltip right>
            <template v-slot:activator="{ on, attrs }">
              <v-avatar
                v-bind="attrs"
                v-on="on"
                size="33"
                :color="productStyle(item.product, 'color')"
              >
                <span class="white--text text-h7">{{
                  productStyle(item.product, "initials")
                }}</span>
              </v-avatar>
            </template>
            <span>{{ item.product }}</span>
          </v-tooltip>
        </template>
        <template v-slot:[`item.value`]="{ item }">
          <v-chip
            color="green lighten-1"
            :class="dark_theme ? 'white--text ' : 'green--text text--lighten-1'"
            small
            :outlined="!dark_theme"
          >
            <span v-if="item.value" class="second_font-bold">{{
              "R$ " + (+item.value).toFixed(2)
            }}</span>
            <span v-else class="second_font">Aguardando</span>
          </v-chip>
        </template>
        <template v-slot:[`item.status`]="{ item }">
          <div :class="'chip gradient-' + statusStyle(item.status, 'gradient')">
            <div class="chip__content">
              <v-icon :color="statusStyle(item.status, 'color')">{{
                statusStyle(item.status, "icon")
              }}</v-icon>
              <span class="item-select-badge">{{ item.status }}</span>
            </div>
          </div>
        </template>
        <template v-slot:[`item.indicator.full_name`]="{ item }">
          <v-menu bottom right transition="scale-transition" origin="top left">
            <template v-slot:activator="{ on }">
              <v-chip pill v-on="on">
                <v-avatar left>
                  <v-img
                    v-if="true"
                    src="https://cdn.vuetifyjs.com/images/john.png"
                  ></v-img>
                  <v-icon v-else>mdi-account-circle</v-icon>
                </v-avatar>
                {{ item.indicator.name }}
              </v-chip>
            </template>
            <v-card width="300" class="style-title">
              <v-list>
                <v-img
                  height="100px"
                  src="./../assets/images/bg1.png"
                  gradient="to bottom left, rgba(173,12,227,.5), rgba(0,260,145,.6)"
                  dark
                  class="pt-5 text-center"
                >
                  <v-list-item>
                    <v-list-item-avatar>
                      <img
                        v-if="true"
                        alt="Foto"
                        src="https://cdn.vuetifyjs.com/images/john.png"
                      />
                      <v-tooltip top v-else>
                        <template v-slot:activator="{ on, attrs }">
                          <v-icon large v-bind="attrs" v-on="on">
                            mdi-account-circle
                          </v-icon>
                        </template>
                        <span>Sem foto</span>
                      </v-tooltip>
                    </v-list-item-avatar>
                    <v-list-item-content>
                      <v-list-item-title>
                        {{ item.indicator.full_name }}
                      </v-list-item-title>
                      <v-list-item-subtitle>
                        {{ item.indicator.role }}
                      </v-list-item-subtitle>
                    </v-list-item-content>
                    <v-list-item-action>
                      <v-tooltip top>
                        <template v-slot:activator="{ on, attrs }">
                          <v-icon
                            v-bind="attrs"
                            v-on="on"
                            v-if="item.indicator.active == 1"
                            color="green"
                            right
                            >mdi-check-circle</v-icon
                          >
                          <v-icon
                            v-bind="attrs"
                            v-on="on"
                            v-else
                            color="red"
                            right
                            >mdi-close-circle</v-icon
                          >
                        </template>
                        <span>{{
                          item.indicator.active == 1
                            ? "Usuário Ativo"
                            : "Usuário Desativado"
                        }}</span>
                      </v-tooltip>
                    </v-list-item-action>
                  </v-list-item>
                </v-img>
              </v-list>

              <v-list>
                <v-list-item @click="() => {}">
                  <v-list-item-action>
                    <v-icon>mdi-arrow-left</v-icon>
                  </v-list-item-action>
                  <v-list-item-title>Perfil</v-list-item-title>
                </v-list-item>
              </v-list>
            </v-card>
          </v-menu>
        </template>
        <template v-slot:[`item.seller.full_name`]="{ item }">
          <v-menu
            bottom
            right
            transition="scale-transition"
            origin="top left"
            v-if="item.seller"
          >
            <template v-slot:activator="{ on }">
              <v-chip pill v-on="on">
                <v-avatar left>
                  <v-img
                    v-if="true"
                    src="https://cdn.vuetifyjs.com/images/john.png"
                  ></v-img>
                  <v-icon v-else>mdi-account-circle</v-icon>
                </v-avatar>
                {{ item.seller.name }}
              </v-chip>
            </template>
            <v-card width="300" class="style-title">
              <v-list>
                <v-img
                  height="100px"
                  src="./../assets/images/bg1.png"
                  gradient="to bottom left, rgba(173,12,227,.5), rgba(0,260,145,.6)"
                  dark
                  class="pt-5 text-center"
                >
                  <v-list-item>
                    <v-list-item-avatar>
                      <img
                        v-if="true"
                        alt="Foto"
                        src="https://cdn.vuetifyjs.com/images/john.png"
                      />
                      <v-tooltip top v-else>
                        <template v-slot:activator="{ on, attrs }">
                          <v-icon large v-bind="attrs" v-on="on">
                            mdi-account-circle
                          </v-icon>
                        </template>
                        <span>Sem foto</span>
                      </v-tooltip>
                    </v-list-item-avatar>
                    <v-list-item-content>
                      <v-list-item-title>
                        {{ item.seller.full_name }}
                      </v-list-item-title>
                      <v-list-item-subtitle>
                        {{ item.seller.role }}
                      </v-list-item-subtitle>
                    </v-list-item-content>
                    <v-list-item-action>
                      <v-tooltip top>
                        <template v-slot:activator="{ on, attrs }">
                          <v-icon
                            v-bind="attrs"
                            v-on="on"
                            v-if="item.seller.active == 1"
                            color="green"
                            right
                            >mdi-check-circle</v-icon
                          >
                          <v-icon
                            v-bind="attrs"
                            v-on="on"
                            v-else
                            color="red"
                            right
                            >mdi-close-circle</v-icon
                          >
                        </template>
                        <span>{{
                          item.seller.active == 1
                            ? "Usuário Ativo"
                            : "Usuário Desativado"
                        }}</span>
                      </v-tooltip>
                    </v-list-item-action>
                  </v-list-item>
                </v-img>
              </v-list>

              <v-list>
                <v-list-item @click="() => {}">
                  <v-list-item-action>
                    <v-icon>mdi-arrow-left</v-icon>
                  </v-list-item-action>
                  <v-list-item-title>Perfil</v-list-item-title>
                </v-list-item>
              </v-list>
            </v-card>
          </v-menu>
          <v-tooltip top v-else>
            <template v-slot:activator="{ on, attrs }">
              <v-chip pill outlined v-bind="attrs" v-on="on">
                <v-icon left>mdi-account-clock</v-icon>
                <span style="font-size: 11px">Aguardando</span>
              </v-chip>
            </template>
            <span>O produto ainda não foi vendido</span>
          </v-tooltip>
        </template>
        <template v-slot:[`item.operator.full_name`]="{ item }">
          <v-menu
            bottom
            right
            transition="scale-transition"
            origin="top left"
            v-if="item.operator"
          >
            <template v-slot:activator="{ on }">
              <v-chip pill v-on="on">
                <v-avatar left>
                  <v-img
                    v-if="true"
                    src="https://cdn.vuetifyjs.com/images/john.png"
                  ></v-img>
                  <v-icon v-else>mdi-account-circle</v-icon>
                </v-avatar>
                {{ item.operator.name }}
              </v-chip>
            </template>
            <v-card width="300" class="style-title">
              <v-list>
                <v-img
                  height="100px"
                  src="./../assets/images/bg1.png"
                  gradient="to bottom left, rgba(173,12,227,.5), rgba(0,260,145,.6)"
                  dark
                  class="pt-5 text-center"
                >
                  <v-list-item>
                    <v-list-item-avatar>
                      <img
                        v-if="true"
                        alt="Foto"
                        src="https://cdn.vuetifyjs.com/images/john.png"
                      />
                      <v-tooltip top v-else>
                        <template v-slot:activator="{ on, attrs }">
                          <v-icon large v-bind="attrs" v-on="on">
                            mdi-account-circle
                          </v-icon>
                        </template>
                        <span>Sem foto</span>
                      </v-tooltip>
                    </v-list-item-avatar>
                    <v-list-item-content>
                      <v-list-item-title>
                        {{ item.operator.full_name }}
                      </v-list-item-title>
                      <v-list-item-subtitle>
                        {{ item.operator.role }}
                      </v-list-item-subtitle>
                    </v-list-item-content>
                    <v-list-item-action>
                      <v-tooltip top>
                        <template v-slot:activator="{ on, attrs }">
                          <v-icon
                            v-bind="attrs"
                            v-on="on"
                            v-if="item.operator.active == 1"
                            color="green"
                            right
                            >mdi-check-circle</v-icon
                          >
                          <v-icon
                            v-bind="attrs"
                            v-on="on"
                            v-else
                            color="red"
                            right
                            >mdi-close-circle</v-icon
                          >
                        </template>
                        <span>{{
                          item.operator.active == 1
                            ? "Usuário Ativo"
                            : "Usuário Desativado"
                        }}</span>
                      </v-tooltip>
                    </v-list-item-action>
                  </v-list-item>
                </v-img>
              </v-list>

              <v-list>
                <v-list-item @click="() => {}">
                  <v-list-item-action>
                    <v-icon>mdi-arrow-left</v-icon>
                  </v-list-item-action>
                  <v-list-item-title>Perfil</v-list-item-title>
                </v-list-item>
              </v-list>
            </v-card>
          </v-menu>
          <v-tooltip top v-else>
            <template v-slot:activator="{ on, attrs }">
              <v-chip pill outlined v-bind="attrs" v-on="on">
                <v-icon left>mdi-account-clock</v-icon>
                <span style="font-size: 11px">Aguardando</span>
              </v-chip>
            </template>
            <span>Aguardando confirmação da UPS</span>
          </v-tooltip>
        </template>
        <template v-slot:[`item.actions`]="{ item }">
          <v-speed-dial
            :id="item.id"
            direction="left"
            open-on-hover
            transition="slide-x-reverse-transition"
          >
            <template v-slot:activator>
              <v-btn :id="item.id" color="rgba(18,210,175)" dark small fab icon>
                <v-icon> mdi-dots-vertical </v-icon>
              </v-btn>
            </template>
            <v-btn
              fab
              dark
              small
              v-if="disableBtns('edit', item)"
              color="yellow darken-2"
              @click="editModal(item)"
            >
              <v-icon>mdi-pencil</v-icon>
            </v-btn>
            <v-tooltip top v-else>
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                  fab
                  dark
                  small
                  color="yellow darken-2"
                  v-bind="attrs"
                  v-on="on"
                >
                  <v-icon>mdi-pencil-off</v-icon>
                </v-btn>
              </template>
              <span>Edição bloqueada</span>
            </v-tooltip>
            <v-btn
              fab
              dark
              small
              v-if="disableBtns('delete', item)"
              color="red"
              @click="deleteModal(item)"
            >
              <v-icon>mdi-delete</v-icon>
            </v-btn>
            <v-tooltip top v-else>
              <template v-slot:activator="{ on, attrs }">
                <v-btn fab dark small color="red" v-bind="attrs" v-on="on">
                  <v-icon>mdi-delete-off</v-icon>
                </v-btn>
              </template>
              <span>Exclusão bloqueda</span>
            </v-tooltip>
          </v-speed-dial>
        </template>
      </v-data-table>
    </v-card>

    <modal-add
      :open="add_modal"
      @closeAddModal="addModal"
      @addCommission="addCommission"
    ></modal-add>
    <modal-edit
      :open="edit_modal"
      :commission="edited_item"
      @closeEditModal="editModal"
      @editCommission="editCommission"
    ></modal-edit>
    <modal-delete
      :open="delete_modal"
      :commission="deleted_item"
      @closeDeleteModal="deleteModal"
      @deleteCommission="deleteCommission"
    ></modal-delete>
    <v-snackbar
      v-model="snackbar_add"
      timeout="2500"
      elevation="24"
      rounded="pill"
      color="success"
    >
      <v-icon class="pr-3" dark>mdi-check-circle</v-icon>
      <strong style="padding-left: 35px" class="white--text"
        >Dado salvo com sucesso</strong
      >
    </v-snackbar>
    <v-snackbar
      v-model="snackbar_edit"
      timeout="2500"
      elevation="24"
      rounded="pill"
      color="orange"
    >
      <v-icon class="pr-3" dark>mdi-check-circle</v-icon>
      <strong style="padding-left: 35px" class="white--text"
        >Dado editado com sucesso</strong
      >
    </v-snackbar>
    <v-snackbar
      v-model="snackbar_delete"
      timeout="2500"
      elevation="24"
      rounded="pill"
      color="red"
    >
      <v-icon class="pr-3" dark>mdi-alert-circle-check</v-icon>
      <strong style="padding-left: 35px" class="white--text"
        >Dado removido com sucesso</strong
      >
    </v-snackbar>
    <br />
  </div>
</template>

<script>
import ModalAdd from "./Modals/ModalAddCommission.vue";
import ModalEdit from "./Modals/ModalEditCommission.vue";
import ModalDelete from "./Modals/ModalDeleteCommission.vue";
export default {
  name: "CommissionComponent",
  components: { ModalAdd, ModalEdit, ModalDelete },
  data() {
    return {
      items: [],
      expanded: [],
      search: "",
      edited_item: {},
      deleted_item: {},
      loading_commissions: true,
      menu_indicator: false,
      add_modal: false,
      edit_modal: false,
      delete_modal: false,
      snackbar_add: false,
      snackbar_edit: false,
      snackbar_delete: false,
      dark_theme: false,
      headers: [
        { text: "Data", value: "date_indicator", align: "start" },
        { text: "Produto", value: "product" },
        { text: "Valor", value: "value" },
        { text: "Status", value: "status", width: "19%" },
        { text: "Indicador", value: "indicator.full_name" },
        { text: "Vendedor", value: "seller.full_name" },
        { text: "Operador", value: "operator.full_name" },
        { text: "Ações", value: "actions", sortable: false },
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
      product_style: [
        {
          product: "Seguro de Vida - Sicoob Seguradora",
          color: "blue lighten-3",
          initials: "SVS",
        },
        {
          product: "Seguro de Vida",
          color: "blue lighten-3",
          initials: "SV",
        },
        {
          product: "Seguro de Vida Coletivo",
          color: "blue lighten-3",
          initials: "SVC",
        },
        {
          product: "Seguro Auto",
          color: "blue lighten-3",
          initials: "SA",
        },
        {
          product: "Seguro Residencial e Empresarial",
          color: "blue lighten-3",
          initials: "SRE",
        },
        {
          product: "Seguro Agrícola",
          color: "blue lighten-3",
          initials: "SAG",
        },
        {
          product: "Seguro Animal de Elite",
          color: "blue lighten-3",
          initials: "SAE",
        },
        {
          product: "Seguro Equipamentos",
          color: "blue lighten-3",
          initials: "SE",
        },
        {
          product: "Seguro Prestamista",
          color: "blue lighten-3",
          initials: "SP",
        },
        {
          product: "Crédito Consignado",
          color: "green lighten-3",
          initials: "CC",
        },
        {
          product: "Consórcio",
          color: "orange lighten-3",
          initials: "C",
        },
      ],
    };
  },
  created() {
    this.getCommissions();
  },
  /*computed: {
      commission_print () {
        return item => {
          if (item.indicator == item.seller) {
            return item.indicator + ': R$ ' + (item.indicator_commission + item.seller_commission) + ' - ' + item.operator + ': R$ ' + item.operator_commission        
          } else if (item.indicator == item.operator) {
            return item.indicator + ': R$ ' + (item.indicator_commission + item.operator_commission) + ' - ' + item.seller + ': R$ ' + item.seller_commission
          } else {
            return item.indicator + ': R$ ' + item.indicator_commission + ' - ' + item.seller + ': R$ ' + item.seller_commission + ' - ' + item.operator + ': R$ ' + item.operator_commission
          }  
        }
      }
    },*/
  methods: {
    disableBtns(type, item) {
      let logged_user_id = this.$store.state.user.id;
      let logged_user_access = this.$store.state.user.accesses.commissions;
      if (type == "edit") {
        return !(
          logged_user_access == "indicator" && item.user_id != logged_user_id
        );
      } else {
        switch (logged_user_access) {
          case "indicator":
            return !(
              item.status != "Aguard. Venda" ||
              item.user_id != logged_user_id
            );
          case "seller":
            return !(
              item.status == "Aprovado UPS" ||
              item.status == "Recusado UPS" ||
              item.user_id != logged_user_id
            );
          case "operator":
            return true;
        }
      }
    },
    productStyle(product, type) {
      let value = "";
      this.product_style.forEach((item) => {
        if (item.product == product) {
          if (type == "color") {
            value = item.color;
          } else {
            value = item.initials;
          }
        }
      });
      return value;
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
    formatDate(date, type) {
      if (type == "d_m") {
        let day_month = date.slice(5, 10);
        let day = day_month.slice(3);
        let month = day_month.slice(0, 2);
        return day + "/" + month;
      }
      if (type == "y") {
        return date.slice(0, 4);
      }
    },
    commissionPrint(item) {
      if (item.indicator_id == item.seller_id) {
        return (
          "<span class='blue--text ma-2'>Indicador e Vendedor: </span>" +
          item.indicator.full_name +
          ": <span class='green--text ma-2'>R$ " +
          (+item.indicator_commission + +item.seller_commission) +
          "</span><br><span class='blue--text ma-2'>Operador: </span>" +
          item.operator.full_name +
          ": <span class='green--text ma-2'>R$ " +
          item.operator_commission +
          "</span>"
        );
      } else if (item.indicator_id == item.operator_id) {
        return (
          "<span class='blue--text ma-2'>Indicador e Operador: </span>" +
          item.indicator.full_name +
          ": <span class='green--text ma-2'>R$ " +
          (+item.indicator_commission + +item.operator_commission) +
          "</span><br><span class='blue--text ma-2'>Vendedor: </span>" +
          item.seller.full_name +
          ": <span class='green--text ma-2'>R$ " +
          item.seller_commission +
          "</span>"
        );
      } else {
        return (
          "<span class='blue--text ma-2'>Indicador: </span>" +
          item.indicator.full_name +
          ": <span class='green--text ma-2'>R$ " +
          item.indicator_commission +
          "</span><br><span class='blue--text ma-2'>Vendedor: </span>" +
          item.seller.full_name +
          ": <span class='green--text ma-2'>R$ " +
          item.seller_commission +
          "</span><br><span class='blue--text ma-2'>Operador: </span>" +
          item.operator.full_name +
          ": <span class='green--text ma-2'>R$ " +
          item.operator_commission
        );
      }
    },
    getCommissions() {
      this.$http.get("get_commissions").then((response) => {
        this.items = response.data;
        this.loading_commissions = false;
      });
    },
    addModal() {
      this.add_modal = !this.add_modal;
    },
    editModal(item = {}) {
      this.edited_item = {};
      Object.assign(this.edited_item, item);
      this.edit_modal = !this.edit_modal;
    },
    deleteModal(item = {}) {
      this.deleted_item = {};
      Object.assign(this.deleted_item, item);
      this.delete_modal = !this.delete_modal;
    },
    addCommission(item) {
      item.user_id = this.$store.state.user.id;
      this.$http.post("add_commission", item).then((response) => {
        this.items.push(response.data);
        this.addModal();
        this.snackbar_add = true;
      });
    },
    editCommission(item) {
      this.$http.put(`edit_commission/${item.id}`, item).then((response) => {
        this.items = this.items.map((commission) =>
          commission.id !== item.id ? commission : response.data
        );
        this.editModal();
        this.snackbar_edit = true;
      });
    },
    deleteCommission(id) {
      this.$http.delete(`delete_commission/${id}`).then(() => {
        this.items = this.items.filter((commission) => {
          return commission.id !== id;
        });
        this.deleteModal();
        this.snackbar_delete = true;
      });
    },
  },
};
</script>
<style scoped>
.item-select-badge {
  font-size: 13px;
  padding-left: 5px;
}

.fixing {
  position: absolute;
  top: 30vw;
  left: 93vw;
}
.hover-card {
  box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px,
    rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
  transition: box-shadow 0.3s;
}
.hover-card:hover {
  box-shadow: rgba(0, 0, 0, 0.3) 0px 19px 38px,
    rgba(0, 0, 0, 0.22) 0px 15px 12px;
}
.title-card-dark {
  color: white;
  font-weight: bolder;
  font-family: "Quicksand", sans-serif;
  transition: 0.8s;
  background-color: rgb(24, 25, 26);
  border-bottom: solid;
  border-width: 1px;
  border-color: rgba(18, 210, 175);
}
.style-title {
  font-weight: bolder;
  font-family: "Quicksand", sans-serif;
}
.title-card {
  font-weight: bolder;
  font-family: "Quicksand", sans-serif;
  transition: 0.8s;
  border-bottom: solid;
  border-width: 2px;
  border-color: rgba(18, 210, 175);
}
.hover-card:hover .title-card,
.hover-card:hover .title-card-dark {
  transition: 0.4s;
  color: rgba(18, 210, 175);
}
.data-table-commission {
  font-weight: 600;
  transition: 0.8s;
}

.tooltip {
  position: relative;
  display: inline-block;
}
.tooltip .tooltiptext {
  font-size: 1px;
  visibility: hidden;
  width: 40px;
  background-color: rgb(44, 44, 44);
  color: #fff;
  text-align: center;
  padding: 5px 0;
  border-radius: 6px;
  position: absolute;
  z-index: 1;
  top: 20%;
  left: 65%;
  opacity: 0;
  transition: 0.3s;
}
.tooltip .tooltiptext::after {
  content: "";
  position: absolute;
  top: 30%;
  left: -2%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: transparent rgb(44, 44, 44) transparent transparent;
}
.tooltip:hover .tooltiptext {
  font-size: 12px;
  visibility: visible;
  opacity: 0.9;
  width: 240px;
  top: 5%;
  left: 105%;
}
.second_font-bold {
  font-family: "Varela Round", sans-serif;
  font-weight: 700;
}
.second_font {
  font-family: "Varela Round", sans-serif;
}
.v-tooltip__content {
  background-color: rgb(36, 33, 33) !important;
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