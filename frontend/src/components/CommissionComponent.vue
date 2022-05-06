<template>
  <div>
    <v-card class="hover-card" outlined shaped>
    <v-card-title :class="dark_theme ? 'title-card-dark' : 'title-card'">
      Produtos e Comissões
      <v-spacer></v-spacer>
      <v-text-field
        v-model="search"
        append-icon="mdi-magnify"
        label="Pesquisar"
        :dark="dark_theme"
        single-line
        color="rgba(18,210,175)"
        hide-details
      ></v-text-field>
    </v-card-title>
    <v-data-table
      :dark="dark_theme"
      class="data-table-commission"
      :loading="loading_commissions"
      :headers="headers"
      :items="items"
      :search="search"
      :sort-by="['date', 'value']"
      multi-sort
      show-expand
      :expanded.sync="expanded"
      :footerProps="{itemsPerPageText:'Vendas por página:', itemsPerPageOptions: [10,30,50,100]}"
      no-data-text="Nenhum dado inserido"
      :headerProps="{sortByText: 'Ordenar Por:'}"
      no-results-text="Não há nenhum registro acerca da pesquisa informada"
      loading-text="Carregando..."
    >
      <template v-slot:[`footer.page-text`]="items"> {{ items.pageStart }} até {{ items.pageStop }} - Total: <strong>{{ items.itemsLength }}</strong> </template>
      <template v-slot:expanded-item="{ headers, item }">
        <td :colspan="headers.length">
          <span><strong class="blue--text">Comissões de {{item.product}}:</strong></span>
          <br>
          <span>{{commissionPrint(item)}}</span>
        </td>
      </template>
      <template v-slot:[`item.date`]="{ item }">
        <v-chip
          color="blue-grey lighten-2"
          small
        >
          <v-tooltip left>
            <template v-slot:activator="{ on, attrs }">
              <span v-bind="attrs" v-on="on">
              {{ formatDate(item.date, 0) }}
              </span>
            </template>
            <span>{{ formatDate(item.date, 1) }}</span>
          </v-tooltip>  
        </v-chip>
      </template>
      <template v-slot:[`item.value`]="{ item }">
       
          <v-chip
            color="green lighten-1"
            dark
            small
            
          >
            {{'R$ ' + (+item.value).toFixed(2) }}
          </v-chip>
        
      </template>
       <template v-slot:[`item.status`]="{ item }">
        <v-chip
          class="ma-0"
          :color="statusStyle(item.status, 'color')"
          text-color="white"
        >
          <v-icon>{{ statusStyle(item.status, 'icon') }}</v-icon>
          <span class="item-select-badge">{{item.status}}</span>
        </v-chip>
      </template>
      <template v-slot:[`item.actions`]="{ item }">
        <v-speed-dial
           
          :id="item.id"
          direction="left"
          open-on-hover
          transition="slide-x-reverse-transition"
        >
          <template v-slot:activator>
            <v-btn
              :id="item.id"
              color="rgba(18,210,175)"
              dark
              small
              fab
              icon
            >
              <v-icon v-if="item.menu">
                mdi-close
              </v-icon>
              <v-icon v-else>
                mdi-dots-vertical
              </v-icon>
            </v-btn>
          </template>
          <v-btn
            fab
            dark
            small
            color="yellow darken-2"
            @click="editModal(item)"
          >
            <v-icon>mdi-pencil</v-icon>
          </v-btn>
          <v-btn
            fab
            dark
            small
            color="red"
            @click="deleteModal(item)"
          >
            <v-icon>mdi-delete</v-icon>
          </v-btn>
    </v-speed-dial>
      </template>
    </v-data-table>
  </v-card>
  
  <modal-add :open="add_modal" @closeAddModal="addModal" @addCommission="addCommission"></modal-add>  
  <modal-edit :open="edit_modal" :commission="edited_item" @closeEditModal="editModal" @editCommission="editCommission"></modal-edit>  
  <modal-delete :open="delete_modal" :commission="deleted_item" @closeDeleteModal="deleteModal" @deleteCommission="deleteCommission"></modal-delete>  
  <v-snackbar
    v-model="snackbar_add"
    timeout="2500"
    elevation="24"
    rounded="pill"
    color="success"
  >
    <v-icon class="pr-3" dark >mdi-check-circle</v-icon>
    <strong style="padding-left: 35px" class="white--text">Dado salvo com sucesso</strong>
  </v-snackbar>
  <v-snackbar
    v-model="snackbar_edit"
    timeout="2500"
    elevation="24"
    rounded="pill"
    color="orange"

  >
    <v-icon class="pr-3" dark >mdi-check-circle</v-icon>
    <strong style="padding-left: 35px" class="white--text">Dado editado com sucesso</strong>
  </v-snackbar>  
  <v-snackbar
    v-model="snackbar_delete"
    timeout="2500"
    elevation="24"
    rounded="pill"
    color="red"
  >
    <v-icon class="pr-3" dark >mdi-alert-circle-check</v-icon>
    <strong style="padding-left: 35px" class="white--text">Dado removido com sucesso</strong>
  </v-snackbar>
  <br>
  
  <div class="tooltip">
    <v-btn
        rounded
        elevation="9"
        :color="!dark_theme ? 'rgb(36, 0, 121)' : 'yellow lighten-2'"
        :dark="!dark_theme"
        @click="dark_theme = !dark_theme"
        small
      >
        <strong>Tema</strong>
        <v-icon
          dark
          right
        >
          {{!dark_theme ? 'mdi-weather-night' : 'mdi-white-balance-sunny'}}
        </v-icon>
      </v-btn>
    <span class="tooltiptext">{{!this.dark_theme ? 'Mudar o tema de cores para "dark"' : 'Mudar o tema de cores para "light"'}}</span>
  </div>
  <div class="">
    <v-tooltip left>
      <template v-slot:activator="{ on, attrs }">
        <v-btn
        color="rgb(0, 209, 94)"
        dark
        fab
        right
        fixed
        v-bind="attrs"
        v-on="on"
        @click="addModal()"
        >
          <v-icon>
            mdi-plus
          </v-icon>
        </v-btn>
      </template>
      <span>Adicionar</span>
    </v-tooltip>
  </div>
</div>
</template>

<script>
import ModalAdd from './Modals/ModalAddCommission.vue'
import ModalEdit from './Modals/ModalEditCommission.vue'
import ModalDelete from './Modals/ModalDeleteCommission.vue'
  export default {
    name: 'CommissionComponent',
    components: { ModalAdd, ModalEdit, ModalDelete },
    data () {
      return {
        items: [],
        expanded: [],
        search: '',
        edited_item: {},
        deleted_item: {},
        loading_commissions: true,
        add_modal: false,
        edit_modal: false,
        delete_modal: false,
        snackbar_add: false,
        snackbar_edit: false,
        snackbar_delete: false,
        dark_theme: false,
        headers: [
          { text: 'Data', value: 'date', align: 'start' },
          { text: 'Produto', value: 'product' },
          { text: 'Valor', value: 'value' },
          { text: 'Status', value: 'status' },
          { text: 'Indicador', value: 'indicator' },
          { text: 'Vendedor', value: 'seller' },
          { text: 'Operador', value: 'operator' },
          { text: 'Ações', value: 'actions', sortable: false },
        ],
        status_style: [
          {status: 'Aguardando Venda', color: 'blue lighten-1', icon: 'mdi-store-clock-outline'},
          {status: 'Venda não realizada', color: 'blue-grey darken-1', icon: 'mdi-store-remove-outline'},
          {status: 'Aguardando UPS', color: 'orange darken-1', icon: 'mdi-account-tie'},
          {status: 'Aceito UPS', color: 'green', icon: 'mdi-check-outline'},
          {status: 'Recusado UPS', color: 'red', icon: 'mdi-close-outline'},
        ]
      }
    },
    created () {
      this.getCommissions()
    },
    /*computed: {
      commission_print () {
        return item => {
          console.log(item, 'computed')
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
      statusStyle (status, type) {
        let value = ''
        this.status_style.forEach((item) => {
          if (item.status == status) {
            if (type == 'color') {
              value = item.color 
            } else {
              value = item.icon
            } 
          }    
        })
        return value
      },
      formatDate (date, type) {
        if (type == 0) {
          let day_month = date.slice(5)
          let day = day_month.slice(3)
          let month = day_month.slice(0,2)
          return (day + '/' + month)
        } else {
          return date.slice(0,4)
        }
      },
      commissionPrint (item) {
        if (item.indicator == item.seller) {
          return item.indicator + ': R$ ' + (item.indicator_commission + item.seller_commission) + ' - ' + item.operator + ': R$ ' + item.operator_commission        
        } else if (item.indicator == item.operator) {
          return item.indicator + ': R$ ' + (item.indicator_commission + item.operator_commission) + ' - ' + item.seller + ': R$ ' + item.seller_commission
        } else {
          return item.indicator + ': R$ ' + item.indicator_commission + ' - ' + item.seller + ': R$ ' + item.seller_commission + ' - ' + item.operator + ': R$ ' + item.operator_commission
        }
      },
      getCommissions () {
        this.$http.get('get_commissions').then((response)=>{
          this.items = response.data; 
          this.loading_commissions = false
        })
      },
      addModal () {
        this.add_modal = !this.add_modal
      },
      editModal (item = {}) {
        this.edited_item = {}
        Object.assign(this.edited_item, item)
        this.edit_modal = !this.edit_modal
      },
      deleteModal (item = {}) {
        this.deleted_item = {}
        Object.assign(this.deleted_item, item)
        this.delete_modal = !this.delete_modal
      },
      addCommission (item) {
        this.$http.post('add_commission', item).then((response)=>{
          console.log(response.data)
          this.items.push(response.data)
          this.addModal()
          this.snackbar_add = true
        })
      },
      editCommission (item) {
        this.$http.put(`edit_commission/${item.id}`, item).then((response)=>{
          console.log(response.data)
          this.items = this.items.map(commission => commission.id !== item.id ? commission : response.data)
          this.editModal()
          this.snackbar_edit = true
        })  
      },
      deleteCommission (id) {
        this.$http.delete(`delete_commission/${id}`).then((response)=>{
          console.log(response.data)
          this.items = this.items.filter(( commission )=>{
            return commission.id !== id  
          })
          this.deleteModal()
          this.snackbar_delete = true
        })  
      }
    }
  }
</script>
<style scoped>
  .item-select-badge {
    padding-left:5px
  }
  .fixing {
    position: absolute;
    top:30vw;
    left:93vw;
  }
  .hover-card {
    box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;  
    transition: box-shadow .3s;
  }
  .hover-card:hover {
    box-shadow: rgba(0, 0, 0, 0.3) 0px 19px 38px, rgba(0, 0, 0, 0.22) 0px 15px 12px; 
  }
  .title-card-dark {
    color:white;
    font-weight: bolder;
    font-family: 'Quicksand', sans-serif;
    transition: .8s;
    background-color: rgb(24, 25, 26);
    border-bottom: solid;
    border-width: 1px;
    border-color:rgba(18,210,175);
  }
  .title-card {
    font-weight: bolder;
    font-family: 'Quicksand', sans-serif;
    transition: .8s;
    border-bottom: solid;
    border-width: 2px;
    border-color:rgba(18,210,175);
  }
  .hover-card:hover .title-card, .hover-card:hover .title-card-dark{
    transition: .4s;
    color: rgba(18,210,175); 
  }
  .data-table-commission {
    font-weight: 600;
    transition: .8s;
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
    border-color: transparent rgb(44, 44, 44) transparent  transparent;
  }
  .tooltip:hover .tooltiptext {
    font-size: 12px;
    visibility: visible;
    opacity: 0.9;
    width: 240px;
    top: 5%;
    left: 105%;
  }
</style>