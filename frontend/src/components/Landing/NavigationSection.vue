<template>
  <div>
    <v-app-bar
      class="app-class"
      app
      :color="color"
      :flat="flat"
      dark
      src="@/assets/images/bg2.png"
      :class="{ expand: flat }"
    >

      <v-toolbar-title>
        <v-img src="@/assets/images/sicoobicon.png" class="mt-2" style="display:inline-block" max-width="30px" />
        <strong class="mx-3" style="top:16px; position:absolute;">Credisg Software</strong>
  
      </v-toolbar-title>
      <v-spacer />
      <v-app-bar-nav-icon
        @click.stop="drawer = !drawer"
        class="mr-4"
        v-if="isXs"
      />
      <div v-else>
        <v-btn text @click="$vuetify.goTo('#hero')">
          <span class="mr-2">Home</span>
        </v-btn>
        <v-btn text @click="$vuetify.goTo('#features')">
          <span class="mr-2">Sobre</span>
        </v-btn>
        <v-btn text @click="$vuetify.goTo('#download')">
          <span class="mr-2">Download</span>
        </v-btn>
        <v-btn text @click="$vuetify.goTo('#pricing')">
          <span class="mr-2">Preços</span>
        </v-btn>
      </div>
    </v-app-bar>
  </div>
</template>

<style scoped>
.v-toolbar {
  transition: 0.6s;
}

.expand {
  height: 80px !important;
  padding-top: 10px;
}
</style>

<script>
export default {
  data: () => ({
    isXs: false,
    items: [
      ['mdi-home-outline', 'Home', '#hero'],
      ['mdi-information-outline', 'Sobre', '#features'],
      ['mdi-download-box-outline', 'Download', '#download'],
      ['mdi-currency-usd', 'Preços', '#pricing'],
    ],
  }),
  props: {
    color: String,
    flat: Boolean,
  },
  methods: {
    onResize() {
      this.isXs = window.innerWidth < 850;
    },
  },

  watch: {
    isXs(value) {
      if (!value) {
        if (this.drawer) {
          this.drawer = false;
        }
      }
    },
  },
  mounted() {
    this.onResize();
    window.addEventListener('resize', this.onResize, { passive: true });
  },
};
</script>
<style scoped>
.app-class {
  transition: 0.3s;
  opacity: 1;
}
</style>