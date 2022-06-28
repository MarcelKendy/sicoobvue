<template>
  <div>
    <v-dialog v-model="dialog" persistent max-width="650">
      <v-card :dark="dark_theme" :loading="loading">
        <v-divider></v-divider>
        <template slot="progress">
          <v-progress-linear
            color="red"
            height="10"
            indeterminate
          ></v-progress-linear>
        </template>
        <v-card-title class="title-modal" v-if="!loading">
          <strong>Deletar Tarefa</strong>
          <v-spacer></v-spacer>
          <img width="30" src="../../assets/images/sicoobicon.png" />
        </v-card-title>
        <v-card-title class="title-modal" v-else>
          <strong>Deletando</strong>
          <v-spacer></v-spacer>
          <img width="50" src="../../assets/images/loading.gif" />
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text class="mt-4" v-if="!loading">
          <p>
            <strong :class="dark_theme ? 'white--text' : 'black--text'"
              >Você tem certeza que deseja
              <span class="red--text">DELETAR</span> o registro a seguir? </strong
            ><strong
              class="red--text"
              style="font-size: 12px; text-decoration: underline red"
              >(Esse processo é irreversível)</strong
            >
          </p>

          <v-alert
            icon="mdi-alert"
            color="red"
            border="left"
            elevation="7"
            dark
            prominent
          >
            <strong>Nome: </strong> {{ item.title }}
            <v-spacer></v-spacer>

            <v-spacer></v-spacer>
          </v-alert>
        </v-card-text>
        <v-card-text class="mt-7" v-else>
          <v-row align="center" justify="center">
            <v-col cols="12">
              <v-alert
                color="red"
                border="left"
                elevation="3"
                dark
                icon="mdi-delete-clock"
              >
                <span>Espera só um pouquinho, carregando...</span>
              </v-alert>
            </v-col>
          </v-row>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="$emit('closeModalDelete')">
            Cancelar
          </v-btn>
          <v-btn color="red darken-1" text @click="deleteTask"> Deletar </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  props: ['task'],
  data() {
    return {
      dialog: true,
      item: {},
      loading: false,
    };
  },
  created() {
    Object.assign(this.item, this.task);
  },
  methods: {
    deleteTask() {
      this.loading = true;
      this.$http.delete(`delete_task/${this.item.id}`).then(() => {
        this.$emit('taskDeleted', this.item.id);
        this.$emit('closeModalDelete');
        this.loading = false;
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

<style scoped>
.title-modal {
  font-family: 'Quicksand', sans-serif;
  color: red;
}
</style>