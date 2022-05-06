<template>
  <div>
      <v-dialog
      v-model="dialog"
      persistent
      max-width="700"
    > 
      <v-card>
        <v-card-title class="title-modal">
          <strong>Adicionar Comissão</strong>
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
              color="rgb(0, 209, 94)"
              min-width="auto"
            >
              <template v-slot:activator="{ on, attrs }">
                <v-text-field
                  color="rgb(0, 209, 94)"
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
                color="rgb(0, 209, 94)"
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
              color="rgb(0, 209, 94)"
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
                color: 'rgb(0, 209, 94)',
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
            <v-text-field-money
              
              label="Valor Comissão R$"
              v-bind:properties="{
                prependIcon: 'mdi-cash',
                color: 'rgb(0, 209, 94)',
                class: 'px-3',
                placeholder: 'Valor a ser comissionado',
                disabled: item.product != 'Seguro Prestamista',
                outlined: true,
                //v_model: item.product == 'Seguro Prestamista' ? item.custom_value : item.value 
              }"
              v-model="item.product == 'Seguro Prestamista' ? item.custom_value : item.value"
            ></v-text-field-money>
          </v-col>  
        </v-row>
        <v-row align="center">
         <v-col
            cols="12"
            md="6"
          >
            <v-text-field
              class="px-3"
              label="Indicador"
              color="rgb(0, 209, 94)"
              prepend-icon="mdi-bullhorn-outline"
              placeholder="Nome Completo do Indicador"
              v-model="item.indicator"
              outlined
            ></v-text-field>
          </v-col>  
          <v-col
            cols="12"
            md="6"
          >
            <v-text-field
              class="px-3"
              label="Vendedor"
              color="rgb(0, 209, 94)"
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
              color="rgb(0, 209, 94)"
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
            color="rgb(0, 209, 94)"
            text
            @click="addCommission()"
          >
            Salvar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
    props: ['open'],
    data () {
        return {
            dialog: false,
            date_picker: false,
            item: { 
              user_id: '',
              date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10), 
              product: '', 
              value: '', 
              indicator: '', 
              seller: '', 
              operator: '', 
              status: '',
              indicator_commission: 0,
              seller_commission: 0, 
              operator_commission: 0 
            },
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
        addCommission () {
          this.item.user_id = this.$store.state.user.id
          this.$emit('addCommission', this.item)
          this.item = {date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)}
        },
        closeModal () {
          this.$emit('closeAddModal')      
          this.item = {date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)}
        }
    }
}
</script>

<style scoped>
  .title-modal {
    font-family: 'Quicksand', sans-serif;
    color: rgb(0, 209, 94);
  }
  .item-select-badge {
    font-weight:bold;
    padding-left:5px
  }
</style>