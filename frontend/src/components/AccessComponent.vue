<template>
  <div>
    <v-card
      class="font-quicksand my-10 mx-10 hover-card"
      outlined
      shaped
      :loading="loading"
    >
      <v-card-title class="bold title-card">
        Acessos
        <img
          v-if="loading"
          width="70"
          class="loading-gif"
          src="../assets/images/loading.gif"
        />
      </v-card-title>
      <v-card-subtitle class="bold">
        Acessos definidos no sistema
      </v-card-subtitle>
      <v-card-text>
        <v-tooltip right v-if="!loading">
          <template v-slot:activator="{ on, attrs }">
            <v-btn v-bind="attrs" v-on="on" @click="addModal()" color="rgb(0, 209, 94)" dark>
              <v-icon>mdi-plus</v-icon>
            </v-btn>
          </template>
          <span>Novo Acesso</span>
        </v-tooltip>

        <v-expansion-panels v-if="!loading" class="mt-8">
          <v-expansion-panel v-for="item in items" :key="item.id">
            <v-expansion-panel-header class="name-accesses-title bold">
              <template v-slot:actions>
                <v-icon color="primary" style="order: 0"> $expand </v-icon>
              </template>
              <template v-slot="{ open }">
                <div style="order: 1; display: inline-flex">
                  <span class="mx-3" style="padding-top: 10px" v-if="!open">{{
                    item.name
                  }}</span>
                  <v-col sm="3" cols="12" v-else>
                    <v-tooltip right>
                      <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                          dense
                          small
                          @click.stop
                          @change="changeAccess(item, 0)"
                          v-model="item.name"
                          :loading="changing_access_name"
                          class="name-accesses-title shrink"
                          append-icon="mdi-pencil"
                          v-bind="attrs"
                          v-on="on"
                        >
                        </v-text-field>
                      </template>
                      <span>Edição Automática</span>
                    </v-tooltip>
                  </v-col>
                  <v-spacer></v-spacer>
                  <div style="order: 3; display: inline-flex">
                    <v-tooltip left>
                      <template v-slot:activator="{ on, attrs }">
                        <v-btn
                          icon
                          v-bind="attrs"
                          v-on="on"
                          @click.stop="deleteModal(item)"
                        >
                          <v-icon color="red">mdi-delete</v-icon>
                        </v-btn>
                      </template>
                      <span>Deletar Acesso</span>
                    </v-tooltip>
                  </div>
                </div>
              </template>
            </v-expansion-panel-header>

            <v-expansion-panel-content>
              <v-divider></v-divider>
              <v-card class="mt-5 pa-2" elevation="0" outlined>
                <span class="name-accesses bold">Módulo Acessos:</span>
                <v-row class="mt-2">
                  <v-col cols="12" md="3">
                    {{typeof item.accesses}}
                    <v-select
                      :loading="changing_accesses_access"
                      :disabled="changing_accesses_access"
                      :menu-props="{ offsetY: true }"
                      outlined
                      @change="changeAccess(item, 1)"
                      :items="accesses_accesses"
                      item-text="name"
                      item-value="value"
                      color="rgb(18,210,175)"
                      label="Tela de acessos"
                      v-model="item.accesses.accesses"
                      prepend-icon="mdi-monitor-lock"
                    >
                      <template v-slot:selection="{ item }">
                        <div
                          :class="
                            'chip gradient-' +
                            accessStyle(item.value, 'gradient')
                          "
                        >
                          <div class="chip__content">
                            <v-icon color="white">{{
                              accessStyle(item.value, "icon")
                            }}</v-icon>
                            <span class="item-select-badge">{{
                              item.name
                            }}</span>
                          </div>
                        </div>
                      </template>
                      <template v-slot:item="{ item }">
                        <div
                          :class="
                            'chip gradient-' +
                            accessStyle(item.value, 'gradient')
                          "
                        >
                          <div class="chip__content">
                            <v-icon color="white">{{
                              accessStyle(item.value, "icon")
                            }}</v-icon>
                            <span class="item-select-badge">{{
                              item.name
                            }}</span>
                          </div>
                        </div>
                      </template>
                    </v-select>
                  </v-col>
                </v-row>
              </v-card>
              <v-card class="mt-5 pa-2" elevation="0" outlined>
                <span class="name-commissions bold">Módulo Comissões:</span>
                <v-row class="mt-2">
                  <v-col cols="12" md="3">
                    <v-select
                      :loading="changing_commissions_access"
                      :disabled="changing_commissions_access"
                      :menu-props="{ offsetY: true }"
                      outlined
                      @change="changeAccess(item, 2)"
                      :items="commissions_accesses"
                      item-text="name"
                      item-value="value"
                      color="rgb(18,210,175)"
                      label="Tela de comissões"
                      v-model="item.accesses.commissions"
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
                            <v-icon
                              :color="commissionStyle(item.value, 'color')"
                              >{{ commissionStyle(item.value, "icon") }}</v-icon
                            >
                            <span class="item-select-badge">{{
                              item.name
                            }}</span>
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
                            <v-icon
                              :color="commissionStyle(item.value, 'color')"
                              >{{ commissionStyle(item.value, "icon") }}</v-icon
                            >
                            <span class="item-select-badge">{{
                              item.name
                            }}</span>
                          </div>
                        </div>
                      </template>
                    </v-select>
                  </v-col>
                </v-row>
              </v-card>
            </v-expansion-panel-content>
          </v-expansion-panel>
        </v-expansion-panels>
      </v-card-text>
    </v-card>
     <modal-add
      :open="add_modal"
      @closeAddModal="addModal"
      @addAccess="addAccess"
    ></modal-add>
    <modal-delete
      :open="delete_modal"
      :access="deleted_item"
      @closeDeleteModal="deleteModal"
      @deleteAccess="deleteAccess"
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
  </div>
</template>

<script>
import ModalDelete from "./Modals/ModalDeleteAccess.vue";
import ModalAdd from "./Modals/ModalAddAccess.vue";
export default {
  name: "AccessComponent",
  components: { ModalAdd, ModalDelete },
  data: () => ({
    items: [],
    deleted_item: {},
    add_modal: false,
    delete_modal: false,
    snackbar_add: false,
    snackbar_delete: false,
    changing_access_name: false,
    changing_accesses_access: false,
    changing_commissions_access: false,
    loading: false,
    color: "blue",
    accesses_accesses: [
      { value: 1, name: "Permitido" },
      { value: 0, name: "Bloqueado" },
    ],
    commissions_accesses: [
      { value: "indicator", name: "Indicador" },
      { value: "seller", name: "Vendedor" },
      { value: "operator", name: "Operador" },
    ],
    access_style: [
      {
        name: 1,
        color: "green",
        icon: "mdi-lock-open-check",
        gradient: "success",
      },
      {
        name: 0,
        color: "red",
        icon: "mdi-lock",
        gradient: "error",
      },
    ],
    commission_style: [
      {
        name: "indicator",
        color: "#5b75dc",
        icon: "mdi-bullhorn-outline",
        gradient: "blue",
      },
      {
        name: "seller",
        color: "#5f6e8b",
        icon: "mdi-account-tie-voice",
        gradient: "gray",
      },
      {
        name: "operator",
        color: "orange darken-3",
        icon: "mdi-account-tie",
        gradient: "orange",
      },
    ],
  }),
  created() {
    this.getAccesses();
  },
  methods: {
    loaderAccess(module, on = true) {
      switch (module) {
        case 0:
          this.changing_access_name = on;
          break;
        case 1:
          this.changing_accesses_access = on;
          break;
        case 2:
          this.changing_commissions_access = on;
          break;
      }
    },
    changeAccess(item, module) {
      this.loaderAccess(module);
      this.$http.put(`edit_access/${item.id}`, item).then((response) => {
        this.items = this.items.map((access) =>
          access.id !== item.id ? access : response.data
        );
        this.loaderAccess(module, false);
      });
    },
    getAccesses() {
      this.loading = true;
      this.$http.get("get_accesses").then((response) => {
        this.items = response.data;
        this.loading = false;
      });
    },
     addAccess(item) {
      this.$http.post("add_access", item).then((response) => {
        this.items.push(response.data);
        this.addModal();
        this.snackbar_add = true;
      });
    },
    deleteAccess(id) {
      this.$http.delete(`delete_access/${id}`).then(() => {
        this.items = this.items.filter((access) => {
          return access.id !== id;
        });
        this.deleteModal();
        this.snackbar_delete = true;
      });
    },
    commissionStyle(name, type) {
      let value = "";
      this.commission_style.forEach((item) => {
        if (item.name == name) {
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
    accessStyle(name, type) {
      let value = "";
      this.access_style.forEach((item) => {
        if (item.name == name) {
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
    addModal() {
      this.add_modal = !this.add_modal;
    },
    deleteModal(item = {}) {
      this.deleted_item = {};
      Object.assign(this.deleted_item, item);
      this.delete_modal = !this.delete_modal;
    },
  },
};
</script>
<style scoped>
.loading-gif {
  display: block;
  margin-left: auto;
  margin-right: auto;
}
.name-accesses-title {
  color: rgb(0, 101, 209);
}
.name-accesses {
  font-size: 16px;
  color: rgb(125, 188, 255);
}
.name-commissions {
  font-size: 16px;
  color: rgba(18, 210, 175);
}

.item-select-badge {
  font-family: "Quicksand", sans-serif;
  font-size: 13px;
  padding-left: 5px;
}
.chip {
  max-width: 150px;
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
.chip:hover {
  background-position: right center; /* change the direction of the change here */
}
.chip__content {
  color: white;
  margin-right: 1px;
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
.title-card {
  transition: 0.5s;
}
.hover-card:hover .title-card {
  color: rgb(0, 2, 125);
}
.hover-card {
  transition: 0.5s;
  box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px,
    rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
  transition: box-shadow 0.3s;
}
.hover-card:hover {
  box-shadow: rgba(0, 0, 0, 0.3) 0px 19px 38px,
    rgba(0, 0, 0, 0.22) 0px 15px 12px;
}
</style>