<template>
  <div>
      <v-dialog
      v-model="dialog"
      persistent
      max-width="350"
    > 
      <v-card>
        <v-card-title class="text-h5">
          Delete
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text class="mt-4">
          Are you sure that you want to delete the task "{{this.item.title}}" ?      
        </v-card-text>
         
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="blue darken-1"
            text
            @click="$emit('closeModalDelete')"
          >
            Cancel
          </v-btn>
          <v-btn
            color="red darken-1"
            text
            @click="deleteTask"
          >
            Delete
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
        Object.assign(this.item, this.task);
    },
    methods: {
        deleteTask () {
            //this.$store.dispatch('deleteTask', this.item.id)
            this.$http.delete(`delete_task/${this.item.id}`).then((response)=>{
              console.log(response.data)
              this.$emit('taskDeleted', this.item.id)
              this.$emit('closeModalDelete')    
            })  
        }
    }
}
</script>

<style>

</style>