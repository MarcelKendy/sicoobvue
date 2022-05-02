<template>
  <div>
    <v-container>
          <v-slide-y-transition>

          
            <v-card
              v-if="show_card"
              outlined
              shaped
              class="hover-card"
            >
              <v-card-title class="title-card" style="font-family: 'Quicksand', sans-serif;"><strong>Add a New Task:</strong></v-card-title>
              <v-card-subtitle style="font-family: 'Quicksand', sans-serif;"><strong> Fill the information and click "Confirm", or press "enter"</strong></v-card-subtitle>
              <v-card-text>
                <v-col
                  cols="12"
                >
                  <v-text-field
                    color="success"
                    label="Task name"
                    placeholder="Type the name"
                    outlined
                    v-model="new_task.title"
                    dense
                    @keyup.enter="addTask"
                  ></v-text-field>
                  <v-text-field
                    color="success"
                    label="Description"
                    placeholder="Type the description"
                    outlined
                    v-model="new_task.subtitle"
                    dense
                    @keyup.enter="addTask"
                  ></v-text-field>
                </v-col>  
              </v-card-text>
              <v-card-actions style="padding-right:30px">
                <v-spacer></v-spacer>
                <v-btn
                  :loading="false"
                  color="success"
                  @click="addTask"
                >
                  <span>Confirm</span>    
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-slide-y-transition>  
    </v-container>
    
    
     
    <tasks-list transition="slide-y-reverse-transition" @taskEdited="edited_task" @taskDeleted="deleted_task" @showCard="card_active" :tasks="items" :loading="loading_tasks"></tasks-list>
    
    <v-snackbar
      v-model="snackbarActivate"
      timeout="2500"
      elevation="24"
      rounded="pill"
      color="success"
    >
      <strong style="padding-left: 35px" class="white--text">{{ text_included }}</strong>
    </v-snackbar>
      
  </div>
</template>

<script>
//<v-icon size="100" color="red lighten-1">mdi-emoticon-sad</v-icon> <v-img src="../assets/images/thamaraespeio.png" max-width="100px" max-height="150px"></v-img>
// <div v-else>
//      <tile color="#03fca9"></tile>
//</div>
 import TasksList from '../components/Tasks/TasksList.vue'
  export default {
    name: 'TasksView',
    components: {
     TasksList
    },
    data () {
      return {
        new_task: {title: '', subtitle: ''},
        items: [],
        snackbarActivate: false,
        show_card: false,
        text_included: 'Data has been saved successfully!',
        loading_tasks: true
      }
    },
    methods: {
      addTask () {
        //this.$store.dispatch('addTask', this.new_task) 
        this.$http.post('add_task', this.new_task).then((response)=>{
          console.log(response.data)
          this.items.push(response.data)
          this.snackbarActivate = true
        })
        this.new_task.title = ''
        this.new_task.subtitle = ''
      },
      getTasks() {
        this.$http.get('get_tasks').then((response)=>{
          this.items = response.data;  
          this.loading_tasks = false
        })
      },
      deleted_task(id) {
        this.items = this.items.filter(function( task ) {
          return task.id !== id
        })
      },
      edited_task(task) {
        this.items = this.items.map(item => item.id !== task.id ? item : task)
      },
      card_active(active) {
        this.show_card = active
      }
    },
    created () {
      this.getTasks()
      //this.$store.commit('getTasks') 
    }
  }
  //sm="6" md="4"
</script>
<style scoped>
  .progress {
     margin: auto;
     padding: 10px;
  }
  .changeColor {
    color:aqua
  }
  .hover-card {
    box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;  
    transition: box-shadow .3s;
  }
  .hover-card:hover {
    box-shadow: rgba(0, 0, 0, 0.3) 0px 19px 38px, rgba(0, 0, 0, 0.22) 0px 15px 12px; 
  }
  .title-card {
    transition: .4s;
  }
  .hover-card:hover .title-card {
    transition: .4s;
    color: #4caf50; 
  }
</style>