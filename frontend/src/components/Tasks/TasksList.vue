<template>
  <div>
    <v-card
      elevation="12"
      outlined
      :shaped="no_tasks"
      class="mx-auto my-12"
      width="98%"
      :dark="dark_theme"
    >
      <v-toolbar color="rgba(18,210,195)" dark>
        <div class="tooltip_plus">
          <v-fab-transition>
            <v-btn
              :key="this.card_active ? 1 : 0"
              color="green"
              fab
              dark
              small
              @click="addCard()"
            >
              <v-icon>{{ this.card_active ? 'mdi-close' : 'mdi-plus' }}</v-icon>
            </v-btn> </v-fab-transition
          ><span class="tooltiptext_plus">{{
            this.card_active ? 'Fechar' : 'Nova Tarefa'
          }}</span>
        </div>

        <v-toolbar-title
          style="padding-left: 20px; font-family: 'Quicksand', sans-serif"
          ><strong>CheckList</strong></v-toolbar-title
        >
        <div style="padding-left: 40px">
          <v-tooltip id="tooltip" top color="rgb(44, 44, 44)">
            <template v-slot:activator="{ on, attrs }">
              <v-icon v-bind="attrs" v-on="on">mdi-magnify</v-icon>
            </template>
            <span>Procure suas tarefas por nome ou por descrição</span>
          </v-tooltip>
        </div>
        <div style="padding-left: 18px; padding-top: 20px">
          <v-text-field
            class="search"
            placeholder="Pesquisar..."
            :disabled="loading"
            v-model="search"
          ></v-text-field>
        </div>
        <v-spacer></v-spacer>

        <div
          @click="filterDone"
          v-if="this.$vuetify.breakpoint.name != 'xs'"
          class="tooltip"
          style="
            box-shadow: rgba(0, 0, 0, 0.2) 0px 7px 10px,
              rgba(0, 0, 0, 0.32) 0px 2px 2px;
            border-radius: 10px;
            cursor: pointer;
          "
        >
          <span
            style="
              padding-left: 10px;
              font-family: 'Quicksand', sans-serif;
              font-weight: bold;
            "
            >{{
              this.done_filter ? 'Tarefas Concluídas ' : 'Todas as tarefas '
            }}</span
          >
          <v-btn :loading="done_filter_loading" icon>
            <v-icon>{{
              this.done_filter
                ? 'mdi-checkbox-marked-circle'
                : 'mdi-checkbox-marked-circle-outline'
            }}</v-icon> </v-btn
          ><span class="tooltiptext">{{
            this.done_filter ? 'Mostrar tudo' : 'Mostrar concluídas'
          }}</span>
        </div>
        <v-btn v-else :loading="done_filter_loading" icon @click="filterDone">
          <v-icon>{{
            this.done_filter
              ? 'mdi-checkbox-marked-circle'
              : 'mdi-checkbox-marked-circle-outline'
          }}</v-icon>
        </v-btn>
      </v-toolbar>
      <v-spacer></v-spacer>
      <div
        v-if="loading"
        align="center"
        justify="center"
        style="padding-bottom: 20px; padding-top: 20px"
      >
        <v-progress-circular
          :size="40"
          :width="7"
          color="rgba(18,210,195)"
          indeterminate
        ></v-progress-circular>
      </div>
      <div
        v-else-if="no_tasks"
        class="mt-16 animate__animated animate__bounceInUp"
      >
        <center style="padding-bottom: 60px">
          <v-icon size="50" color="rgba(18,210,195)">mdi-emoticon-sad</v-icon>
          <div
            style="
              color: rgba(18, 210, 195);
              font-size: 24px;
              font-weight: bold;
              font-family: 'Quicksand', sans-serif;
            "
          >
            Nenhuma tarefa encontrada
          </div>
        </center>
      </div>
      <drop-list v-else :items="items" @reorder="$event.apply(items)">
        <template v-slot:item="{ item, reorder }">
          <drag :key="item.id" :data="item">
            <tasks-component
              @taskDeleted="deleted_task"
              @taskEdited="edited_task"
              @doneEdited="edited_done"
              :task="item"
              style="background-color: white"
              :style="
                reorder
                  ? { borderLeft: '6px solid #1976D2', marginLeft: '-2px' }
                  : {}
              "
            ></tasks-component>
            <v-divider />
          </drag>
        </template>
      </drop-list>
    </v-card>
    <v-snackbar
      v-model="snackbar_delete_activate"
      timeout="2500"
      elevation="24"
      rounded="pill"
      color="red"
    >
      <v-icon class="pr-3" dark>mdi-alert-circle-check</v-icon>
      <strong style="padding-left: 35px" class="white--text"
        >Dado removido com sucesso</strong
      >
    </v-snackbar>
  </div>
</template>

<script>
import { Drag, DropList } from 'vue-easy-dnd';
import TasksComponent from './TasksComponent.vue';
export default {
  components: { Drag, DropList, TasksComponent },
  props: ['tasks', 'loading'],
  data() {
    return {
      snackbar_delete_activate: false,
      items: [],
      tasksMutable: [],
      search: '',
      done_filter: false,
      done_filter_loading: false,
      no_tasks: false,
      card_active: false,
    };
  },
  created() {
    this.items = this.tasks;
    this.tasksMutable = this.tasks;
  },
  methods: {
    edited_task(task) {
      this.$emit('taskEdited', task);
      this.filterEdited(task);
    },
    edited_done(id) {
      if (this.done_filter) {
        this.items = this.items.filter((task) => {
          return task.id !== id;
        });
      }
    },
    deleted_task(id) {
      this.$emit('taskDeleted', id);
      this.filterDeleted(id);
      this.snackbar_delete_activate = true;
    },
    filterDeleted(id) {
      this.tasksMutable = this.tasksMutable.filter(function (task) {
        return task.id !== id;
      });
      this.watchSearch();
    },
    filterEdited(task) {
      this.tasksMutable = this.tasksMutable.map((taskMutable) =>
        taskMutable.id !== task.id ? taskMutable : task
      );
      this.watchSearch();
    },
    filterTasks() {
      this.items = [];
      if (this.done_filter) {
        this.items = this.tasksMutable.filter((task) => {
          return (
            this.search
              .toLowerCase()
              .split(' ')
              .every(
                (search_char) =>
                  task.title.toLowerCase().includes(search_char) ||
                  task.subtitle.toLowerCase().includes(search_char)
              ) && task.done
          );
        });
      } else {
        this.items = this.tasksMutable.filter((task) => {
          return this.search
            .toLowerCase()
            .split(' ')
            .every(
              (search_char) =>
                task.title.toLowerCase().includes(search_char) ||
                task.subtitle.toLowerCase().includes(search_char)
            );
        });
      }
      this.done_filter_loading = false;
    },
    filterDone() {
      (this.done_filter_loading = true), (this.done_filter = !this.done_filter);
      if (this.done_filter) {
        this.items = this.items.filter((task) => {
          return task.done;
        });
        this.done_filter_loading = false;
      } else {
        this.watchSearch();
      }
    },
    watchSearch() {
      if (this.search.length > 0) {
        this.filterTasks();
      } else {
        this.items = [];
        if (this.done_filter) {
          this.items = this.tasksMutable.filter((task) => {
            return task.done;
          });
        } else {
          this.items = this.tasksMutable;
        }
        this.done_filter_loading = false;
      }
    },
    watchItemsLength() {
      if (!this.items.length) {
        this.no_tasks = true;
      } else {
        if (this.no_tasks) {
          this.no_tasks = false;
        }
      }
    },
    addCard() {
      this.card_active = !this.card_active;
      this.$emit('showCard', this.card_active);
    },
  },
  watch: {
    search: function () {
      this.watchSearch();
    },
    items: function () {
      this.watchItemsLength();
    },
    tasks: function () {
      this.tasksMutable = [];
      this.tasksMutable = this.tasks;
      this.watchSearch();
    },
  },
  computed: {
    dark_theme() {
      try {
        return this.$store.state.user.configs.theme == 0;
      } catch (err) {
        return false;
      }
    },
  },
};
</script>

<style>
.search {
  padding-top: 150px;
}
.tooltip {
  position: relative;
  display: inline-block;
}
.tooltip .tooltiptext {
  font-size: 1px;
  visibility: hidden;
  width: 40px;
  background-color: rgb(44, 44, 44);
  color: #fff;
  text-align: center;
  padding: 5px 0;
  border-radius: 6px;
  position: absolute;
  z-index: 1;
  top: -40px;
  bottom: auto;
  /*right: -10%; */
  left: 40%;
  opacity: 0;
  transition: 0.3s;
}
.tooltip .tooltiptext::after {
  content: '';
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: rgb(44, 44, 44) transparent transparent transparent;
}
.tooltip:hover .tooltiptext {
  font-size: 15px;
  visibility: visible;
  opacity: 0.9;
  width: 140px;
  left: 12%;
  right: 0;
}
.tooltip_plus {
  position: relative;
  display: inline-block;
}
.tooltip_plus .tooltiptext_plus {
  visibility: hidden;
  width: 40px;
  background-color: rgb(44, 44, 44);
  color: #fff;
  font-size: 4px;
  text-align: center;
  padding: 5px 0;
  border-radius: 6px;
  position: absolute;
  z-index: 1;
  top: -45px;
  bottom: auto;
  left: -40%;
  right: 20%;
  left: 0%;
  opacity: 0;
  transition: 0.4s;
}
.tooltip_plus .tooltiptext_plus::after {
  content: '';
  position: absolute;
  top: 100%;
  left: 39.5%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: rgb(44, 44, 44) transparent transparent transparent;
}
.tooltip_plus:hover .tooltiptext_plus {
  font-size: 15px;
  visibility: visible;
  opacity: 0.9;
  width: 90px;
  bottom: auto;
  left: -40%;
  right: 0;
}
</style>