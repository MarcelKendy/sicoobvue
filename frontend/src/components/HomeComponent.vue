<template>
  <v-container>
    <div :class="dark_theme ? 'white--text' : ''">
      <v-row class="text-center">
        <v-col cols="12" align="center" class="mg-auto">
          <v-img
            :src="require('../assets/images/landing-page.png')"
            width="200"
          />
        </v-col>

        <v-col class="mb-4">
          <h1 class="display-2 font-weight-bold mb-3">Bem Vindo</h1>

          <p class="subheading font-weight-regular"></p>
        </v-col>

        <v-col class="mb-5" cols="12">
          <h2 class="headline font-weight-bold mb-3">
            Aqui será a tela Home/Inicial do sistema
          </h2>
        </v-col>
        <v-col class="mb-5" cols="12">
          <span class="font-weight-bold mb-3">
            Os textos a seguir são para testes de scroll de página, favor
            desconsiderar.
          </span>
        </v-col>
        <v-divider></v-divider>
        <v-col class="mb-5" cols="12">
          <h2 class="headline font-weight-bold mb-3">texto texto</h2>
        </v-col>
        <v-col class="mb-5" cols="12">
          <h2 class="headline font-weight-bold mb-3">
            texto texto texto texto texto texto texto texto texto texto texto
            texto
          </h2>
        </v-col>
        <v-col class="mb-5" cols="12">
          <h2 class="headline font-weight-bold mb-3">texto texto</h2>
        </v-col>
        <v-col class="mb-5" cols="12">
          <h2 class="headline font-weight-bold mb-3">
            texto texto texto texto texto texto texto texto texto texto texto
            texto
          </h2>
        </v-col>
        <v-col class="mb-5" cols="12">
          <h2 class="headline font-weight-bold mb-3">texto texto</h2>
        </v-col>
        <v-col class="mb-5" cols="12">
          <h2 class="headline font-weight-bold mb-3">
            texto texto texto texto texto texto texto texto texto texto texto
            texto
          </h2>
        </v-col>
        <v-col class="mb-5" cols="12">
          <h2 class="headline font-weight-bold mb-3">texto texto</h2>
        </v-col>
        <v-col class="mb-5" cols="12">
          <h2 class="headline font-weight-bold mb-3">
            texto texto texto texto texto texto texto texto texto texto texto
            texto
          </h2>
        </v-col>
        <v-col class="mb-5" cols="12">
          <h2 class="headline font-weight-bold mb-3">texto texto</h2>
        </v-col>
        <v-col class="mb-5" cols="12">
          <h2 class="headline font-weight-bold mb-3">
            texto texto texto texto texto texto texto texto texto texto texto
            texto
          </h2>
        </v-col>
      </v-row>
    </div>
  </v-container>
</template>

<script>
export default {
  name: 'HomeComponent',

  data: () => ({}),
  computed: {
    dark_theme() {
      return this.$store.state.user.configs.theme == 0;
    },
  },
};
</script>
