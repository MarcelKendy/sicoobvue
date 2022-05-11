<template>
  <div>
      <v-dialog
      v-model="dialog"
      persistent
      max-width="650"
    > 
      <v-card :loading="loading">
       <template slot="progress">
          <v-progress-linear
            color="red"
            height="10"
            indeterminate
          ></v-progress-linear>
        </template>
         <v-card-title class="title-modal" v-if="!loading">
          <strong >Deletar Comissão</strong>
          <v-spacer></v-spacer>
           <img width="30" src="../../assets/images/sicoobicon.png"/>
        </v-card-title>
        <v-card-title class="title-modal" v-else>
          <strong>Deletando</strong>
          <v-spacer></v-spacer>
           <img width="50" src="../../assets/images/loading.gif"/>
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text class="mt-4" v-if="!loading">
          <p><strong class="black--text">Você tem certeza que deseja <span class="red--text">DELETAR</span> o registro a seguir? </strong><strong class="red--text" style="font-size:12px;text-decoration: underline red;">(Esse processo é irreversível)</strong></p>
          
          
          <v-banner
            color="red"
            dark
            elevation="7"
            icon="mdi-alert"
            rounded
            single-line
            sticky
          >
          <strong>{{item.date_indicator}} - Produto: </strong>{{item.product}}<strong> - Valor</strong> R$ {{item.value}}
          </v-banner>
        </v-card-text>
        <v-card-text class="mt-7" v-else>
        <v-row align="center" justify="center">  
          <v-col
            cols="12"
          >
          <v-alert
            color="red"
            border="left"
            elevation="3"
            dark
            icon="mdi-delete-clock"
          >
             <span >Espera só um pouquinho</span>
          </v-alert>
           </v-col>
        </v-row>  
        </v-card-text>
         <v-divider></v-divider>
        <v-card-actions v-if="!loading">
          <v-spacer></v-spacer>
          <v-btn
            color="blue darken-1"
            text
            @click="closeModal"
          >
            Cancelar
          </v-btn>
          <v-btn
            color="red darken-1"
            text
            @click="deleteCommission"
          >
            Deletar
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
            loading: false,
            item: {}
        }
    },
    watch: {
      open: function () {
        this.loading = false
        this.dialog = this.open
      },
      commission: function () {
        Object.assign(this.item, this.commission)
      }
    },
    methods: {
        closeModal () {
          this.$emit('closeDeleteModal')    
        },
        deleteCommission () {
          this.loading = true
          this.$emit('deleteCommission', this.item.id)    
        }
    }
}
</script>

<style scoped>
 .title-modal {
    font-family: 'Quicksand', sans-serif;
    color: red
  }
</style>