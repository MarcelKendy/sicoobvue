<template>
  <v-container>
    <div :class="dark_theme ? 'white--text' : ''">
      <v-row>
        <v-col cols="12" align="center" class="mg-auto">
          <v-img
            :src="require('../assets/images/dashboard-1.png')"
            width="200"
          />
        </v-col>
      </v-row>
      <v-row class="text-center" justify="center" align="center">
        <v-col class="mb-4">
          <h1 class="display-2 font-weight-bold mb-3">Bem Vindo</h1>

          <p class="subheading font-weight-regular"></p>
        </v-col>

        <v-col class="mb-5" cols="12">
          <h2 class="headline font-weight-bold mb-3">
            Aqui será a tela de Dashboard
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
  name: 'DashboardComponent',

  data: () => ({}),
  computed: {
    dark_theme() {
       try {
        return this.$store.state.user.configs.theme == 0;
      } catch (err) {
        return false
      }
    },
  },
};
</script>
