<template>
  <div>
      <v-dialog
      v-model="dialog"
      persistent
      max-width="700"
    > 
      <v-card :loading="loading">
        <template slot="progress">
          <v-progress-linear
            :color="color"
            height="10"
            indeterminate
          ></v-progress-linear>
        </template>
       <v-card-title class="title-modal" v-if="!loading">
          <strong >Editar Comissão</strong>
          <v-spacer></v-spacer>
           <img width="30" src="../../assets/images/sicoobicon.png"/>
        </v-card-title>
        <v-card-title class="title-modal" v-else>
          <strong>Salvando</strong>
          <v-spacer></v-spacer>
           <img width="50" src="../../assets/images/loading.gif"/>
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text class="mt-7" v-if="loading">
          <v-row align="center" justify="center">  
            <v-col
              cols="12"
            >
            <v-alert
              :color="color"
              border="left"
              elevation="3"
              dark
              icon="mdi-content-save"
            >
              <span>Espera só um pouquinho</span>
            </v-alert>
            </v-col>
          </v-row>    
        </v-card-text>
        <v-card-text class="mt-4" v-else>
        <v-form ref="form" v-model="valid" lazy-validation>
        <v-row align="center">  
          <v-col
            cols="12"
            sm="6"
          >
            <v-select
              :items="products"
              :rules="requiredRule"
              :color="color"
              label="Produto"
              @change="changeProduct"
              v-model="item.product"
              prepend-icon="mdi-storefront"
            ></v-select>
          </v-col>
         
          <v-col 
            cols="12"
            sm="6"
          >
            <v-select
                :menu-props="{  offsetY: true }"
                outlined
                :items="status"
                :color="color"
                :rules="requiredRule"
                label="Status"
                @change="$refs.form.resetValidation()"
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
        <v-row align="center" v-if="accesses('indicator')">
          <v-col
            cols="12"
            sm="6"
          >
            <v-text-field
              class="px-3"
              label="Indicador"
              :color="color"
              prepend-icon="mdi-bullhorn-outline"
              :rules="requiredRule"
              placeholder="Nome Completo do Indicador"
              v-model="item.indicator"
              outlined
            ></v-text-field>
          </v-col>
          <v-col
            cols="12"
            md="6"
          > 
           <DateTimePicker
              label="Data/Hora da Indicação"
              :clearComponent="clear_datetime_picker"
              v-model="item.date_indicator"
              :color="color"
            ></DateTimePicker>
          </v-col>
        </v-row>
        <div v-if="accesses('seller')">
         <v-divider></v-divider> 
         <br> 
        <v-row align="center">
          <v-col
            cols="12"
            md="6"
          >
            <v-text-field
              class="px-3"
              label="Vendedor"
              :color="color"
              prepend-icon="mdi-account-tie-voice"
              placeholder="Nome Completo do Vendedor"
              v-model="item.seller"
              :rules="requiredRule"
              outlined
            ></v-text-field>
          </v-col>  
        <v-col
          cols="12"
          md="6"
        >
          <DateTimePicker
            label="Data/Hora da Venda"
            :clearComponent="clear_datetime_picker"
            v-model="item.date_seller"
            :color="color"
          ></DateTimePicker>
          </v-col>  
        </v-row>
        <v-row align="center">
          <v-col
            cols="12"
            md="6"
          > 
            <v-text-field-money
              label="Valor (R$)"
              v-bind:properties="{
                prependIcon: 'mdi-cash',
                color: color,
                class: 'px-3',
                rules: requiredRule,
                placeholder: 'Valor efetivo do produto',
                outlined: true,
                suffix: 'R$'
              }"
              v-model="item.value"
            ></v-text-field-money>
          </v-col>
           <v-col
            cols="12"
            md="6"
          > 
            <vuetify-number
              v-model="item.commission_percentage"
              v-bind:label="'Comissão da Cooperativa (%)'"
              v-bind:readonly="((item.product == 'Seguro Prestamista') || (item.product == 'Seguro de Vida - Sicoob Seguradora') || (item.product == 'Consórcio'))"
              v-bind:outlined="true"
              v-bind:rules="requiredRule"
              v-bind:color="color"
              v-bind:valueWhenIsEmpty="null"
              v-bind:options="options"
            />
          </v-col> 
        </v-row>   
        <v-row align="center" v-if="item.product == 'Seguro Prestamista'">
          <v-col
            cols="12"
            md="6"
          >
           <v-text-field-money
              label="Valor a ser Comissionado (R$)"
              v-bind:properties="{
                prependIcon: 'mdi-cash',
                color: color,
                class: 'px-3',
                rules: requiredRule,
                placeholder: 'Valor efetivo a ser comissionado',
                outlined: true,
                suffix: 'R$'
              }"
              v-model="item.custom_value"
            ></v-text-field-money>
          </v-col>
        </v-row> 
        </div>
        <div v-if="accesses('operator')">
        <v-divider></v-divider> 
        <br>
        <v-row align="center">
          <v-col
            cols="12"
            md="6"
          >
            <v-text-field
              class="px-3"
              :rules="requiredRule"
              label="Operador"
              :color="color"
              prepend-icon="mdi-account-tie"
              placeholder="Nome Completo do Operador"
              v-model="item.operator"
              outlined
            ></v-text-field>
          </v-col>  
          <v-col
            cols="12"
            md="6"
          >
             <DateTimePicker
              label="Data/Hora da Operação"
              :clearComponent="clear_datetime_picker"
              v-model="item.date_operator"
              :color="color"
            ></DateTimePicker>
          </v-col>  
        </v-row>
        </div>
        </v-form>
        </v-card-text>
        <v-divider></v-divider> 
        <v-card-actions v-if="!loading">
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
            :color="color"
            text
            @click="editCommission()"
            :disabled="!valid"
          >
            Salvar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import DateTimePicker from '../util/DateTimePicker.vue'
export default {
    props: ['open', 'commission'],
    components: {DateTimePicker},
    data () {
        return {
            color: 'orange',
            valid: true,
            dialog: false,
            loading: false,
            clear_datetime_picker: false,
            item: { 
              user_id: '',
              date_indicator: '',
              date_seller: '',
              date_operator: '',
              product: '', 
              value: '',
              custom_value: '',
              commission_percentage: '', 
              indicator: '', 
              seller: '', 
              operator: '', 
              status: '',
              indicator_commission: '',
              seller_commission: '', 
              operator_commission: '' 
            },
            options: {
              locale: "pt-BR",
              prefix: "",
              suffix: "%",
              length: 4,
              precision: 2,
              prepend_icon: 'mdi-cash-100',
              color: this.color
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
              'Consórcio'
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
            ],
            /* RULES */
            requiredRule: 
               [v => (!!v)  || "Essa informação é obrigatória"]    
            ,
        }
        
    },
    watch: {
        open: function () {
          this.dialog = this.open
          this.loading = false
        },
        commission: function () {
          this.item = this.commission
          if (this.$refs.form) {
            this.$refs.form.resetValidation()
          }
        }
    },
    methods: {
      accesses (type) {
        switch (type) {

          case 'indicator':
            return (this.$store.state.user.accesses.commissions == 'operator' || this.item.user_id == this.$store.state.user.id)

          case 'seller':
            return ((this.$store.state.user.accesses.commissions == 'operator') || (this.$store.state.user.accesses.commissions == 'seller' && (this.item.user_id == this.$store.state.user.id || this.item.full_name == this.$store.state.user.full_name)))

          case 'operator':
            return (this.$store.state.user.accesses.commissions == 'operator')

          default:
            return false 

        }
      },
      changeStatus (item) {
        switch (item) {
          case 'Aguardando Venda':
            this.$refs.form.resetValidation()
            break
        }
      },
      changeProduct (item) {
        switch(item) {
          case 'Seguro Prestamista':
            this.item.custom_value = ''
            this.item.commission_percentage = "40.00"
            break
          case 'Seguro de Vida - Sicoob Seguradora':
            this.item.custom_value = ''
            this.item.commission_percentage = "30.00"
            break
          case 'Consórcio':
            this.item.custom_value = ''
            this.item.commission_percentage = "3.00"
            break
          default:
            this.item.custom_value = ''
            this.item.commission_percentage = ''
            break
        }
      },
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
        this.loading = true
        this.$emit('editCommission', this.item)
        Object.assign(this.item, this.defaultItem)
      },
      closeModal () {
        this.$emit('closeEditModal')  
        Object.assign(this.item, this.defaultItem)    
      }
    },
    computed: {
      defaultItem () {
        return {  
          user_id: '',
          date_indicator: '',
          date_seller: '',
          date_operator: '',
          product: '', 
          value: '',
          custom_value: '',
          commission_percentage: '', 
          indicator: '', 
          seller: '', 
          operator: '', 
          status: '',
          indicator_commission: '',
          seller_commission: '', 
          operator_commission: ''
        }
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