<template>
  <div>
    <v-dialog v-model="dialog" persistent max-width="800">
      <v-card :loading="loading" :dark="dark_theme">
        <template slot="progress">
          <v-progress-linear
            :color="color"
            height="10"
            indeterminate
          ></v-progress-linear>
        </template>
        <v-card-title class="title-modal" v-if="!loading">
          <strong>Adicionar Comissão</strong>
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
                <v-autocomplete
                  :menu-props="{ dark: dark_theme, offsetY: true }"
                  solo
                  :items="associates"
                  :color="color"
                  label="Associado"
                  :rules="requiredRule"
                  placeholder="Enter para confirmar"
                  item-text="associate"
                  item-value="account"
                  v-model="item.associate_account"
                  :loading="loading_associates"
                  prepend-icon="mdi-account"
                  auto-select-first
                  clearable
                >
                  <template v-slot:selection="{ item }">
                     <v-chip :dark="dark_theme" pill class="mr-2">
                      <v-avatar left>
                        <v-img src="@/assets/icons/associate.png"></v-img>
                      </v-avatar>
                      <span class="font-quicksand bold">{{ item.associate }}</span>
                    </v-chip>
                    <v-chip :dark="dark_theme">
                      <v-avatar left>
                        <v-img src="@/assets/icons/account.png"></v-img>
                      </v-avatar>
                      <span class="font-quicksand bold">{{ item.account }}</span>
                    </v-chip>
                  </template>
                  <template v-slot:item="{ item }">
                    <v-chip :dark="dark_theme" pill>
                      <v-avatar left>
                        <v-img src="@/assets/icons/associate.png"></v-img>
                      </v-avatar>
                      <span class="font-quicksand bold">{{ item.associate }}</span>
                    </v-chip>
                    <v-spacer></v-spacer>
                    <v-chip :dark="dark_theme">
                      <v-avatar left>
                        <v-img src="@/assets/icons/account.png"></v-img>
                      </v-avatar>
                      <span class="font-quicksand bold">{{ item.account }}</span>
                    </v-chip>
                  </template>
                  <template v-slot:no-data>
                    <div class="px-4">
                      <span
                        style="
                          font-family: 'Quicksand', sans-serif;
                          font-weight: bold;
                        "
                        >Nenhum associado encontrado / carregando</span
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
                        <span
                          >Se existe um associado (considerando o
                          filtro), houve um erro de rede ou o mesmo não está cadastrado no sistema. Certifique-se de sua
                          conexão e contate um adm.</span
                        >
                      </v-tooltip>
                    </div>
                  </template>
                </v-autocomplete>
              </v-col>
            </v-row>
            <v-row align="center">
              <v-col cols="12" sm="6">
                <v-select
                  :menu-props="{ dark: dark_theme, offsetY: true }"
                  solo
                  :items="products"
                  :rules="requiredRule"
                  :color="color"
                  label="Produto"
                  @change="changeProduct"
                  v-model="item.product"
                  prepend-icon="mdi-storefront"
                ></v-select>
              </v-col>

              <v-col cols="12" sm="6">
                <v-select
                  :menu-props="{ dark: dark_theme, offsetY: true }"
                  solo
                  :items="status_computed"
                  :color="color"
                  :rules="requiredRule"
                  @change="changeStatus"
                  label="Status"
                  v-model="item.status"
                  prepend-icon="mdi-clock"
                >
                  <template v-slot:selection="{ item }">
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
                </v-select>
              </v-col>
            </v-row>
            <v-row align="center">
              <v-col cols="12" sm="6">
                <v-autocomplete
                  :menu-props="{ dark: dark_theme }"
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
                  <template v-slot:selection="item">
                    <v-chip
                      v-bind="item.attrs"
                      close
                      @click:close="deleteChip(1)"
                      :input-value="item.selected"
                      @click="item.select"
                    >
                      <v-avatar left>
                        <v-img
                          v-if="!item.item.photo"
                          :src="
                            require(`./../../assets/icons/${
                              item.item.gender != 2 ? 'man.png' : 'woman.png'
                            }`)
                          "
                        ></v-img>
                        <v-img
                          v-else
                          :src="avatar_path(item.item.photo)"
                        ></v-img>
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
                            item.item.gender != 2 ? 'man.png' : 'woman.png'
                          }`)
                        "
                      ></v-img>
                      <v-img v-else :src="avatar_path(item.item.photo)"></v-img>
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
                      <v-tooltip
                        id="tooltip"
                        top
                        :color="dark_theme ? 'grey darken-3' : ''"
                      >
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
                  :dark="dark_theme"
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
                    :menu-props="{ dark: dark_theme }"
                    class="px-3"
                    label="Vendedor"
                    :color="color"
                    :disabled="accesses('disableSeller')"
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
                    <template v-slot:selection="item">
                      <v-chip
                        close
                        @click:close="deleteChip(2)"
                        v-bind="item.attrs"
                        :input-value="item.selected"
                        @click="item.select"
                      >
                        <v-avatar left>
                          <v-img
                            v-if="!item.item.photo"
                            :src="
                              require(`./../../assets/icons/${
                                item.item.gender != 2 ? 'man.png' : 'woman.png'
                              }`)
                            "
                          ></v-img>
                          <v-img
                            v-else
                            :src="avatar_path(item.item.photo)"
                          ></v-img>
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
                              item.item.gender != 2 ? 'man.png' : 'woman.png'
                            }`)
                          "
                        ></v-img>
                        <v-img
                          v-else
                          :src="avatar_path(item.item.photo)"
                        ></v-img>
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
                        <v-tooltip
                          id="tooltip"
                          top
                          :color="dark_theme ? 'grey darken-3' : ''"
                        >
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
                    :dark="dark_theme"
                    label="Data/Hora da Venda"
                    :updateComponent="update_datetime_picker_seller"
                    @resetValidation="resetValidation"
                    :rules="requiredSellerRule"
                    v-model="item.date_seller"
                    :disabled="accesses('disableSeller')"
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
                      rules: valueRule,
                      disabled: accesses('disableSeller'),
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
                    v-bind:backgroundColor="dark_theme ? '#1E1E1E' : ''"
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
              <v-row align="center" v-if="item.type == 2">
                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="item.consortium_group"
                    label="Grupo"
                    :disabled="accesses('disableSeller')"
                    :outlined="true"
                    :rules="requiredSellerRule"
                    type="number"
                    hide-spin-buttons
                    :color="color"
                    maxlength="11"
                    placeholder="Grupo do consórcio"
                    prepend-icon="mdi-account-box-multiple"
                  />
                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="item.consortium_quota"
                    label="Cota"
                    :disabled="accesses('disableSeller')"
                    :outlined="true"
                    :rules="requiredSellerRule"
                    type="number"
                    hide-spin-buttons
                    :color="color"
                    maxlength="11"
                    placeholder="Cota do consórcio"
                    prepend-icon="mdi-account-box"
                  />
                </v-col>
              </v-row>
            </div>
            <div v-if="accesses('operator')">
              <v-divider></v-divider>
              <br />
              <v-row align="center">
                <v-col cols="12" md="6">
                  <v-autocomplete
                    :menu-props="{ dark: dark_theme }"
                    class="px-3"
                    label="Operador"
                    :color="color"
                    :disabled="accesses('disableOperator')"
                    prepend-icon="mdi-account-tie"
                    :rules="operatorRule"
                    placeholder="Enter para confirmar"
                    v-model="item.operator_id"
                    :items="users"
                    :loading="loading_users"
                    auto-select-first
                    item-text="full_name"
                    item-value="id"
                    solo
                  >
                    <template v-slot:selection="item">
                      <v-chip
                        close
                        @click:close="deleteChip(3)"
                        v-bind="item.attrs"
                        :input-value="item.selected"
                        @click="item.select"
                      >
                        <v-avatar left>
                          <v-img
                            v-if="!item.item.photo"
                            :src="
                              require(`./../../assets/icons/${
                                item.item.gender != 2 ? 'man.png' : 'woman.png'
                              }`)
                            "
                          ></v-img>
                          <v-img
                            v-else
                            :src="avatar_path(item.item.photo)"
                          ></v-img>
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
                              item.item.gender != 2 ? 'man.png' : 'woman.png'
                            }`)
                          "
                        ></v-img>
                        <v-img
                          v-else
                          :src="avatar_path(item.item.photo)"
                        ></v-img>
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
                        <v-tooltip
                          id="tooltip"
                          top
                          :color="dark_theme ? 'grey darken-3' : ''"
                        >
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
                    :dark="dark_theme"
                    label="Data/Hora da Operação"
                    :updateComponent="update_datetime_picker_operator"
                    @resetValidation="resetValidation"
                    :rules="requiredOperatorRule"
                    v-model="item.date_operator"
                    :disabled="accesses('disableOperator')"
                    :color="color"
                    clearable
                  ></DateTimePicker>
                </v-col>
              </v-row>
              <v-row align="center" v-if="item.type == 1">
                <v-col cols="12" md="6">
                  <v-text-field
                    label="Apólice"
                    v-model="item.insurance_policy"
                    placeholder="Apólice do seguro efetivado"
                    :color="color"
                    name="insurance_policy"
                    :rules="requiredOperatorRule"
                    :disabled="accesses('disableOperator')"
                    required
                    prepend-icon="mdi-file-document-check"
                  />
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
          <v-btn
            :color="color"
            :disabled="!valid"
            text
            @click="addCommission()"
          >
            Salvar
          </v-btn>
          <!--:disabled="!valid"-->
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import DateTimePicker from '../Util/DateTimePicker.vue';
export default {
  props: ['open'],
  components: { DateTimePicker },
  data() {
    return {
      color: 'rgb(0, 209, 94)',
      valid: true,
      dialog: false,
      update_datetime_picker: false,
      update_datetime_picker_seller: false,
      update_datetime_picker_operator: false,
      loading: false,
      loading_users: false,
      loading_associates: false,
      users: [],
      associates: [],
      item: {
        user_id: '',
        date_indicator: '',
        date_seller: '',
        date_operator: '',
        associate_account: '',
        product: '',
        value: '',
        custom_value: '',
        commission_percentage: '',
        indicator_id: '',
        seller_id: '',
        operator_id: '',
        insurance_policy: '',
        consortium_group: '',
        consortium_quota: '',
        type: '',
        status: '',
        indicator_commission: '',
        seller_commission: '',
        operator_commission: '',
      },
      options: {
        locale: 'pt-BR',
        prefix: '',
        suffix: '%',
        length: 4,
        precision: 2,
        prepend_icon: 'mdi-cash-100',
        color: this.color,
      },
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
      /* RULES */
      requiredRule: [(v) => !!v || 'Essa informação é obrigatória'],
      requiredSellerRule: [
        (v) =>
          !!v ||
          this.item.status == 'Aguard. Venda' ||
          this.item.status == 'Não Vendido' ||
          this.item.status == '' ||
          'O status selecionado indica que a venda ocorreu, então essa informação é obrigatória',
      ],
      requiredOperatorRule: [
        (v) =>
          !!v ||
          (this.item.status != 'Recusado UPS' &&
            this.item.status != 'Aprovado UPS') ||
          'O status selecionado indica que a UPS avaliou a venda, então essa informação é obrigatória',
      ],
      valueRule: [
        (v) =>
          (!!v && (parseFloat(v) > 0 || 'O valor não pode ser 0')) ||
          this.item.status == 'Aguard. Venda' ||
          this.item.status == 'Não Vendido' ||
          this.item.status == '' ||
          'O status selecionado indica que a venda foi feita, então essa informação é obrigatória',
      ],
      sellerRule: [
        (v) =>
          (!!v &&
            (this.item.seller_id != this.item.operator_id ||
              'O vendedor e o operador devem ser distintos')) ||
          this.item.status == 'Aguard. Venda' ||
          this.item.status == '' ||
          'O status selecionado indica que a venda foi feita ou que houve contato com o cliente, então essa informação é obrigatória',
      ],
      operatorRule: [
        (v) =>
          (!!v &&
            (this.item.operator_id != this.item.seller_id ||
              'O operador e o vendedor devem ser distintos')) ||
          (this.item.status != 'Recusado UPS' &&
            this.item.status != 'Aprovado UPS') ||
          'O status selecionado indica que a UPS avaliou a venda, então essa informação é obrigatória',
      ],
    };
  },
  watch: {
    open: function () {
      this.dialog = this.open;
      this.update_datetime_picker = this.dialog;
      this.update_datetime_picker_seller = this.dialog;
      this.update_datetime_picker_operator = this.dialog;
      if (this.$refs.form) {
        this.$refs.form.resetValidation();
      }
      this.loading = false;
      if (this.dialog) {
        this.getUsers();
        this.getAssociates();
      }
    },
  },
  methods: {
    deleteChip(chip) {
      switch (chip) {
        case 1:
          this.item.indicator_id = '';
          break;
        case 2:
          this.item.seller_id = '';
          break;
        case 3:
          this.item.operator_id = '';
          break;
        default:
          console.log('chip unidentified');
          break;
      }
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
    getUsers() {
      this.loading_users = true;
      this.$http
        .post('get_users', {
          select: ['id', 'name', 'full_name', 'photo', 'gender'],
        })
        .then((response) => {
          this.users = response.data;
          this.loading_users = false;
        });
    },
    getAssociates() {
      this.loading_associates = true;
      this.$http
        .post('get_accounts', {
          select: ['associate', 'cpf_cnpj', 'account'],
        })
        .then((response) => {
          this.associates = response.data;
          this.loading_associates = false;
        });
    },
    resetValidation() {
      if (this.$refs.form) {
        this.$refs.form.resetValidation();
      }
    },
    status() {
      switch (this.$store.state.user.accesses.commissions) {
        case 'indicator':
          this.item.status = 'Aguard. Venda';
          return ['Aguard. Venda'];
        case 'seller':
          return ['Aguard. Venda', 'Não Vendido', 'Aguard. UPS'];
        case 'operator':
          return [
            'Aguard. Venda',
            'Não Vendido',
            'Aguard. UPS',
            'Aprovado UPS',
            'Recusado UPS',
          ];
      }
    },
    accesses(type) {
      switch (type) {
        case 'indicator':
          return (
            this.$store.state.user.accesses.commissions == 'operator' ||
            this.item.user_id == this.$store.state.user.id
          );
        case 'seller':
          return (
            this.$store.state.user.accesses.commissions == 'operator' ||
            this.$store.state.user.accesses.commissions == 'seller'
          );
        case 'operator':
          return this.$store.state.user.accesses.commissions == 'operator';
        case 'disableSeller':
          return this.item.status == 'Aguard. Venda' || this.item.status == '';
        case 'disableOperator':
          return (
            this.item.status != 'Aprovado UPS' &&
            this.item.status != 'Recusado UPS'
          );
        default:
          return false;
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
    changeStatus() {
      if (
        this.item.status != 'Aprovado UPS' &&
        this.item.status != 'Recusado UPS'
      ) {
        this.update_datetime_picker_seller = true;
        this.update_datetime_picker_operator = false;
        this.item.operator_id = this.item.date_operator = '';
        if (this.item.status == 'Aguard. Venda') {
          this.update_datetime_picker_seller = false;
          this.update_datetime_picker_operator = false;
          this.item.seller_id =
            this.item.custom_value =
            this.item.date_seller =
            this.item.value =
              '';
          if (
            this.item.product !== 'Seguro Prestamista' &&
            this.item.product !== 'Seguro de Vida - Sicoob Seguradora' &&
            this.item.product !== 'Consórcio'
          ) {
            this.item.commission_percentage = '';
          }
        } else if (this.item.status == 'Não Vendido') {
          this.item.custom_value = this.item.value = '';
          if (
            this.item.product !== 'Seguro Prestamista' &&
            this.item.product !== 'Seguro de Vida - Sicoob Seguradora' &&
            this.item.product !== 'Consórcio'
          ) {
            this.item.commission_percentage = '';
          }
        }
      } else {
        this.update_datetime_picker_seller = true;
        this.update_datetime_picker_operator = true;
      }

      this.$refs.form.resetValidation();
    },
    /*changeStatus() {
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
        this.item.operator_id = "";
        this.item.date_operator = "";
      } else {
        this.update_datetime_picker_seller = true;
        this.update_datetime_picker_operator = true;
      }
      this.$refs.form.resetValidation();
    },*/
    changeProduct(item) {
      item.startsWith('Seguro')
        ? (this.item.type = 1)
        : item.startsWith('Consórcio')
        ? (this.item.type = 2)
        : (this.item.type = 3);
      switch (item) {
        case 'Seguro Prestamista':
          this.item.custom_value = '';
          this.item.commission_percentage = '40.00';
          break;
        case 'Seguro de Vida - Sicoob Seguradora':
          this.item.custom_value = '';
          this.item.commission_percentage = '30.00';
          break;
        case 'Consórcio':
          this.item.custom_value = '';
          this.item.commission_percentage = '3.00';
          break;
        default:
          this.item.custom_value = '';
          this.item.commission_percentage = '';
          break;
      }
    },
    addCommission() {
      if (this.$refs.form.validate()) {
        this.loading = true;
        this.$emit('addCommission', this.item);
        this.$refs.form.resetValidation();
        Object.assign(this.item, this.defaultItem);
      }
    },
    closeModal() {
      this.$emit('closeAddModal');
      this.$refs.form.resetValidation();
      Object.assign(this.item, this.defaultItem);
    },
    avatar_path(photo_path) {
      return require('../../../../backend/storage/app/' + photo_path);
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
        user_id: '',
        date_indicator: '',
        date_seller: '',
        date_operator: '',
        product: '',
        associate_account: '',
        value: '',
        custom_value: '',
        commission_percentage: '',
        indicator_id: '',
        seller_id: '',
        operator_id: '',
        status: '',
        type: '',
        insurance_policy: '',
        consortium_group: '',
        consortium_quota: '',
        indicator_commission: '',
        seller_commission: '',
        operator_commission: '',
      };
    },
    status_computed() {
      return this.status();
    },
  },
};
</script>

<style scoped>
.title-modal {
  font-family: 'Quicksand', sans-serif;
  color: rgb(0, 209, 94);
}
</style>