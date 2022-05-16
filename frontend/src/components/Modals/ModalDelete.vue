<template>
  <div>
      <v-dialog
      v-model="dialog"
      persistent
      max-width="350"
    > 
      <v-card>
        <v-card-title class="text-h5">
          Deletar
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text class="mt-4">
          Você tem certeza que deseja deletar a tarefa "{{this.item.title}}" ?      
        </v-card-text>
         
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="blue darken-1"
            text
            @click="$emit('closeModalDelete')"
          >
            Cancelar
          </v-btn>
          <v-btn
            color="red darken-1"
            text
            @click="deleteTask"
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
    props: ['task'],
    data () {
        return {
            dialog: true,
            item: {}
        }
        
    },
    created() {
        Object.assign(this.item, this.task)
    },
    methods: {
        deleteTask () {
            this.$http.delete(`delete_task/${this.item.id}`).then(()=>{
              this.$emit('taskDeleted', this.item.id)
              this.$emit('closeModalDelete')    
            })  
        }
    }
}
</script>

<style>

</style>