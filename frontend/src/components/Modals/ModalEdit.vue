<template>
  <div>
      <v-dialog
      v-model="dialog"
      persistent
      max-width="700"
    > 
      <v-card>
        <v-card-title class="text-h5">
          Edit
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text class="mt-4">
            <v-text-field
            class="px-3"
            label="Name"
            placeholder="Input the new name"
            v-model="item.title"
            outlined
            ></v-text-field>
            <v-text-field
            class="px-3"
            label="Description"
            placeholder="Input the new description"
            v-model="item.subtitle"
            outlined
        ></v-text-field>
        </v-card-text>
         
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="red darken-1"
            text
            @click="$emit('closeModalEdit')"
          >
            Cancel
          </v-btn>
          <v-btn
            color="orange"
            text
            @click="editTask"
          >
            Edit
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
        editTask () {
            //this.$store.dispatch('editTask', this.item)
            this.$http.put(`edit_task/${this.item.id}`, this.item).then((response)=>{
              console.log(response.data)
              this.$emit('taskEdited', response.data)
              this.$emit('closeModalEdit') 
            })
                
        }
    }
}
</script>

<style>

</style>