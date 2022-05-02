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
            cols="12"
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
              'Crédito Consignado',
              'Consórcio',
              'Previdência'
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
</style>