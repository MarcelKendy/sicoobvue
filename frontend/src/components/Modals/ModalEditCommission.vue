<template>
  <div>
      <v-dialog
      v-model="dialog"
      persistent
      max-width="700"
    > 
      <v-card>
        <v-card-title class="title-modal">
          <strong>Editar Comissão</strong>
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text class="mt-4">
        <v-row align="center">  
          <v-col
            cols="12"
            sm="6"
          >
            <v-menu
              v-model="date_picker"
              :close-on-content-click="false"
              :nudge-right="40"
              transition="scale-transition"
              offset-y
              color="orange"
              min-width="auto"
            >
              <template v-slot:activator="{ on, attrs }">
                <v-text-field
                  color="orange"
                  v-model="item.date"
                  label="Data da operação:"
                  prepend-icon="mdi-calendar"
                  readonly
                  v-bind="attrs"
                  v-on="on"
                ></v-text-field>
              </template>
              <v-date-picker
                locale="pt-BR"
                color="orange"
                v-model="item.date"
                @input="date_picker = false"
              ></v-date-picker>
            </v-menu>
          </v-col>
          <v-col
            cols="12"
            sm="6"
          >
            <v-select
              :items="products"
              color="orange"
              label="Produto Vendido"
              v-model="item.product"
              prepend-icon="mdi-storefront"
            ></v-select>
          </v-col>
        </v-row>  
        <v-row align="center">
          <v-col
            cols="12"
            md="6"
          >
            <v-text-field-money
              label="Valor R$"
              v-bind:properties="{
                prependIcon: 'mdi-cash',
                color: 'orange',
                class: 'px-3',
                placeholder: 'Valor efetivo do produto',
                outlined: true
              }"
              v-model="item.value"
            ></v-text-field-money>
          </v-col>  
          <v-col
            cols="12"
            md="6"
          >
            <v-text-field
              class="px-3"
              label="Indicador"
              color="orange"
              prepend-icon="mdi-bullhorn-outline"
              placeholder="Nome Completo do Indicador"
              v-model="item.indicator"
              outlined
            ></v-text-field>
          </v-col>  
        </v-row>
        <v-row align="center">
          <v-col
            cols="12"
          >
            <v-text-field
              class="px-3"
              label="Vendedor"
              color="orange"
              prepend-icon="mdi-account-tie-voice"
              placeholder="Nome Completo do Vendedor"
              v-model="item.seller"
              outlined
            ></v-text-field>
          </v-col>  
        </v-row>
        <v-row align="center">
          <v-col
            cols="6"
          >
            <v-text-field
              class="px-3"
              label="Operador"
              color="orange"
              prepend-icon="mdi-account-tie"
              placeholder="Nome Completo do Operador"
              v-model="item.operator"
              outlined
            ></v-text-field>
          </v-col> 
          <v-col
            cols="6"
          >
            <v-select
              :menu-props="{ top: true, offsetY: false }"
              outlined
              :items="status"
              color="rgb(0, 209, 94)"
              label="Status"
              v-model="item.status"
              prepend-icon="mdi-clock"
            >
              <template v-slot:selection="{ item }">
                <v-chip
                  class="ma-0"
                  :color="statusStyle(item, 'color')"
                  text-color="white"
                >
                  
                    <v-icon>{{statusStyle(item, 'icon')}}</v-icon>
                 
                  <span class="item-select-badge">{{item}}</span>
                </v-chip>
              </template>
              <template  v-slot:item="{ item }">
                <v-chip
                  class="ma-0"
                  :color="statusStyle(item, 'color')"
                  text-color="white"
                >
                  
                    <v-icon>{{statusStyle(item, 'icon')}}</v-icon>
                  
                  <span class="item-select-badge">{{item}}</span>
                </v-chip>
              </template>
            </v-select>
          </v-col>   
        </v-row>
        </v-card-text>
        <v-divider></v-divider> 
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="red darken-1"
            dark
            text
            @click="closeModal()"
          >
            Cancelar
          </v-btn>
          <v-btn
            color="orange"
            text
            @click="editCommission()"
          >
            Editar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
    props: ['open', 'commission'],
    data () {
        return {
            dialog: false,
            date_picker: false,
            item: {date: '', product: '', value: '', indicator: '', seller: '', operator: '', indicator_commission: '', seller_commission: '', operator_commission: ''},
            products: [
              'Seguro de Vida Coletivo',
              'Seguro de Vida',
              'Seguro Animal de Elite',
              'Seguro Auto',
              'Seguro Equipamentos',
              'Seguro Residencial e Empresarial',
              'Seguro Agrícola',
              'Seguro Prestamista',
              'Crédito Consignado',
              'Consórcio',
              'Previdência'
            ],
            status: [
              'Aguardando Venda',
              'Venda não realizada',
              'Aguardando UPS',
              'Aceito UPS',
              'Recusado UPS'
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
    watch: {
        open: function () {
          this.dialog = this.open
        },
        commission: function () {
          Object.assign(this.item, this.commission)
        }
    },
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
      editCommission () {
        this.$emit('editCommission', this.item)
      },
      closeModal () {
        this.$emit('closeEditModal')      
      }
    }
}
</script>

<style scoped>
  .title-modal {
    font-family: 'Quicksand', sans-serif;
    color: orange
  }
  .item-select-badge {
    font-weight:bold;
    padding-left:5px
  }
</style>