<template>
  <div>
    <v-menu offset-y>
      <template v-slot:activator="{ on, attrs }">
        <v-btn v-bind="attrs" v-on="on" icon>
          <v-icon>mdi-dots-vertical</v-icon>
        </v-btn>
      </template>
      <v-list>
        <v-list-item
          v-for="(item, index) in items"
          :key="index"
          @click="item.click()"
        >
          <v-icon left :color="item.color">{{ item.icon }}</v-icon>
          <v-list-item-title :style="'color:' + item.color"
            ><strong>{{ item.title }}</strong></v-list-item-title
          >
        </v-list-item>
      </v-list>
    </v-menu>
    <modal-edit
      v-if="items[0].modal"
      :task="task"
      @taskEdited="edited_task"
      @closeModalEdit="items[0].modal = false"
    ></modal-edit>
    <modal-delete
      v-if="items[1].modal"
      :task="task"
      @taskDeleted="deleted_task"
      @closeModalDelete="items[1].modal = false"
    ></modal-delete>

    <v-snackbar
      v-model="snackbar_edit_activate"
      timeout="2500"
      elevation="24"
      rounded="pill"
      color="orange"
    >
      <v-icon class="pr-3" dark>mdi-check-circle</v-icon>
      <strong style="padding-left: 35px" class="white--text"
        >Dado editado com sucesso</strong
      >
    </v-snackbar>
  </div>
</template>

<script>
import ModalEdit from '../Modals/ModalEditTask.vue';
import ModalDelete from '../Modals/ModalDeleteTask.vue';
export default {
  props: ['task'],
  components: { ModalEdit, ModalDelete },
  data: () => ({
    snackbar_edit_activate: false,
    snackbar_delete_activate: false,
    items: [
      {
        icon: 'mdi-pencil',
        color: 'orange',
        title: 'Editar',
        modal: false,
        click() {
          this.modal = true;
        },
      },
      {
        icon: 'mdi-trash-can',
        color: 'red',
        title: 'Deletar',
        modal: false,
        click() {
          this.modal = true;
        },
      },
    ],
  }),
  methods: {
    edited_task(task) {
      this.snackbar_edit_activate = true;
      this.$emit('taskEdited', task);
    },
    deleted_task(id) {
      this.$emit('taskDeleted', id);
    },
  },
};
</script>

<style>
</style>