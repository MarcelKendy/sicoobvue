<template>
  <div style="font-weight: bold">
    <v-list-item
      :dark="dark_theme"
      :class="
        !dark_theme
          ? item.done
            ? 'blue lighten-4 hover-list'
            : 'hover-list'
          : item.done
          ? 'blue hover-list'
          : 'grey darken-3 hover-list'
      "
      @click="doneTask"
    >
      <template v-slot:default="{}">
        <v-list-item-action>
          <v-checkbox :input-value="item.done"></v-checkbox>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title
            :class="
              !dark_theme
                ? item.done
                  ? 'text-decoration-line-through title-done font-italic'
                  : 'black--text'
                : item.done
                ? 'text-decoration-line-through font-italic'
                : 'white--text'
            "
            >{{ item.title }}</v-list-item-title
          >
          <v-list-item-subtitle>{{ item.subtitle }}</v-list-item-subtitle>
        </v-list-item-content>
        <v-list-item-action>
          <tasks-menu
            @taskEdited="edited_task"
            @taskDeleted="deleted_task"
            :task="item"
          ></tasks-menu>
        </v-list-item-action>
      </template>
    </v-list-item>
  </div>
</template>

<script>
import TasksMenu from '../Tasks/TasksMenu.vue';
export default {
  components: { TasksMenu },
  props: ['task'],
  data() {
    return {
      item: {},
      activeItem: true,
    };
  },
  created() {
    this.item = [];
    this.item = this.task;
  },
  methods: {
    edited_task(task) {
      this.$emit('taskEdited', task);
      this.item = task;
    },
    deleted_task(id) {
      this.activeItem = false;
      this.$emit('taskDeleted', id);
    },
    doneTask() {
      this.item.done = !this.item.done;
      this.$http.put(`done_task/${this.item.id}`, this.item).then(() => {
        this.$emit('doneEdited', this.item.id);
      });
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
.title-done {
  font-weight: bolder;
  color: #3852a4;
}
.hover-list {
  transition: box-shadow 0.3s;
}
.hover-list:hover {
  box-shadow: 0 0 20px rgb(65, 123, 209);
}
.hover-list-done {
  transition: box-shadow 0.3s;
}
.hover-list-done:hover {
  box-shadow: 0 0 20px rgb(33, 33, 33);
}
</style>