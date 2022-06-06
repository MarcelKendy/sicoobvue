<template>
  <div>
    <v-dialog v-model="dialog" persistent max-width="650">
      <v-card :dark="dark_theme">
        <v-card-title class="title-modal">
          <strong>Logout</strong>
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text class="mt-4">
          <p>
            <strong :class="dark_theme ? 'white--text' : 'black--text'"
              >Você tem certeza que deseja
              <span class="red--text">SAIR</span> do sistema?</strong
            >
          </p>

          <v-alert color="blue" border="left" elevation="7" dark prominent>
            <template slot="prepend">
              <v-img
                max-width="64px"
                class="mx-5 ml-2"
                src="./../../assets/icons/bots/bot1/bot-bye.png"
              ></v-img>
            </template>
            <h3>Até a próxima!</h3>
            <p class="mt-2">{{new Date().toLocaleString()}}</p>   
          </v-alert>
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