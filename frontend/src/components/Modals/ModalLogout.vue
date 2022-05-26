<template>
  <div>
    <v-dialog v-model="dialog" persistent max-width="650">
      <v-card>
        <v-card-title class="title-modal">
          <strong>Logout</strong>
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text class="mt-4">
          <p>
            <strong class="black--text"
              >Você tem certeza que deseja
              <span class="red--text">SAIR</span> do sistema?</strong
            >
          </p>

          <v-banner
            color="rgba(18,210,175)"
            dark
            elevation="7"
            icon="mdi-robot-excited-outline"
            rounded
            single-line
            sticky
          >
            <strong>Até a próxima!</strong>
          </v-banner>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="closeModal">
            Cancelar
          </v-btn>
          <v-btn color="red darken-1" text @click="logout"> Sair </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  props: ['activate'],
  data() {
    return {
      dialog: false,
    };
  },
  watch: {
    activate: function () {
      this.dialog = this.activate;
    },
  },
  methods: {
    closeModal() {
      this.$emit('closeLogoutModal');
    },
    logout() {
      this.$emit('logout');
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