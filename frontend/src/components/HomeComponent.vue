<template>
  <v-container>
    <v-row class="text-center">
      <v-col cols="12" align="center" class="mg-auto">
        <v-img :src="require('../assets/images/landing-page.png')" width="200" />
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
  </v-container>
</template>

<script>
export default {
  name: 'HomeComponent',

  data: () => ({
    ecosystem: [
      {
        text: 'vuetify-loader',
        href: 'https://github.com/vuetifyjs/vuetify-loader',
      },
      {
        text: 'github',
        href: 'https://github.com/vuetifyjs/vuetify',
      },
      {
        text: 'awesome-vuetify',
        href: 'https://github.com/vuetifyjs/awesome-vuetify',
      },
    ],
    importantLinks: [
      {
        text: 'Documentation',
        href: 'https://vuetifyjs.com',
      },
      {
        text: 'Chat',
        href: 'https://community.vuetifyjs.com',
      },
      {
        text: 'Made with Vuetify',
        href: 'https://madewithvuejs.com/vuetify',
      },
      {
        text: 'Twitter',
        href: 'https://twitter.com/vuetifyjs',
      },
      {
        text: 'Articles',
        href: 'https://medium.com/vuetify',
      },
    ],
    whatsNext: [
      {
        text: 'Explore components',
        href: 'https://vuetifyjs.com/components/api-explorer',
      },
      {
        text: 'Select a layout',
        href: 'https://vuetifyjs.com/getting-started/pre-made-layouts',
      },
      {
        text: 'Frequently Asked Questions',
        href: 'https://vuetifyjs.com/getting-started/frequently-asked-questions',
      },
    ],
  }),
};
</script>
