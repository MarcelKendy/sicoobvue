<template>
  <div>
      <v-dialog
      v-model="dialog"
      persistent
      max-width="650"
    > 
      <v-card>
        <v-card-title class="title-modal">
          <strong>Deletar Comissão</strong>
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text class="mt-4">
          <p><strong class="black--text">Você tem certeza que deseja <span class="red--text">DELETAR</span> o registro a seguir?</strong></p>
          
          <v-banner
            color="red"
            dark
            elevation="7"
            icon="mdi-alert"
            rounded
            single-line
            sticky
          >
          <strong>{{item.date}} - Produto: </strong>{{item.product}}<strong> - Valor</strong> R$ {{item.value}}
          </v-banner>
        </v-card-text>
         <v-divider></v-divider>
        <v-card-actions>
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
            item: {}
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
        closeModal () {
          this.$emit('closeDeleteModal')    
        },
        deleteCommission () {
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