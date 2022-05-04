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
        </v-row>
        <v-row align="center">
          <v-col
            cols="12"
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
            cols="12"
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
              date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10), 
              product: '', 
              value: '', 
              indicator: '', 
              seller: '', 
              operator: '', 
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
              'Crédito Consignado',
              'Consórcio',
              'Previdência'
            ],
            status: [
              'Aguardando Venda',
              'Venda não realizada',
              'Aguardando UPS',
              'Aceito',
              'Recusado'
            ]
        }
        
    },
    watch: {
        open: function () {
          this.dialog = this.open
        }
    },
    methods: {
        addCommission () {
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
</style>