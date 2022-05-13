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
          <strong>Inserido em: </strong>{{created_at_date()}}<strong> Às </strong>{{created_at_time()}}<br><strong>Por: </strong><span v-if="loading_user">Carregando...</span><span v-else>{{user_name}}</span><br><strong>Produto: </strong> {{item.product}}<span v-if="item.value"><br><strong>Valor:</strong> R$ {{item.value}}</span>
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
            loading_user: false,
            loading: false,
            user_name: '',
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
        this.get_info()
      }
    },
    methods: {
        get_info () {
          this.loading_user = true
          this.$http.post('get_users',{where: 'id = ' + this.item.user_id}).then((response)=>{
            this.user_name = response.data[0].full_name
            this.loading_user = false
          })
        },
        closeModal () {
          this.$emit('closeDeleteModal')    
        },
        deleteCommission () {
          this.loading = true
          this.$emit('deleteCommission', this.item.id)    
        },
        created_at_date () {
        let br_date = ''
        if (this.item.created_at) {
          let us_date = this.item.created_at.slice(0,10)
          let year = us_date.slice(0,4)
          let month = us_date.slice(5,7)
          let day = us_date.slice(8)
          br_date = day + '/' + month + '/' + year  
        } 
        return br_date
      },
      created_at_time () {
        let time_formatted = ''
        if (this.item.created_at) {
          let time_raw = this.item.created_at.slice(11)
          let hour = parseInt(time_raw.slice(0,2)) - 3
          let minute = time_raw.slice(3,5)
          time_formatted = hour + ':' + minute  
        }
        return time_formatted
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