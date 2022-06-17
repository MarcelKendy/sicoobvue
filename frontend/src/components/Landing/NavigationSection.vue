<template>
  <div>
    <v-app-bar
      app
      :color="color ? color : 'rgba(8,110,95,.6)'"
      dark
      src="@/assets/images/bg2.png"
      class="opacity-change"
      fade-img-on-scroll
      scroll-threshold="800"
    >
      <v-toolbar-title>
        <v-img
          src="@/assets/images/sicoobicon.png"
          class="mt-2"
          style="display: inline-block"
          max-width="30px"
        />
        <strong class="mx-3" style="top: 16px; position: absolute"
          >{{ $store.state.software.name }}
          <small style="font-weight: 300">{{
            $store.state.software.version
          }}</small></strong
        >
      </v-toolbar-title>
      <v-spacer />
      <v-app-bar-nav-icon
        @click.stop="drawer = !drawer"
        class="mr-4"
        v-if="isXs"
      />
      <div v-else>
        <span
          @click="$vuetify.goTo('#home')"
          class="mx-6 hover-underline-animation"
          >Home</span
        >
        <span
          @click="$vuetify.goTo('#features')"
          class="mx-6 hover-underline-animation"
          >Sobre</span
        >
        <span
          @click="$vuetify.goTo('#software')"
          class="mx-6 hover-underline-animation"
          >Sistema</span
        >
        <span
          @click="$vuetify.goTo('#updates')"
          class="mx-6 hover-underline-animation"
          >Updates</span
        >
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
.opacity-change:hover {
  transition: 0.2s;
  background-color: rgb(0, 61, 72) !important
}
.text-scale-1 {
  font-size: 16px;
  transition: 0.3s;
}
.text-scale-1:hover {
  font-size: 18px;
  transition: 0.3s;
}
.text-scale-2 {
  font-size: 16px;
  transition: 0.3s;
}
.text-scale-2:hover {
  font-size: 18px;
  transition: 0.3s;
}
.text-scale-3 {
  font-size: 16px;
  transition: 0.3s;
}
.text-scale-3:hover {
  font-size: 18px;
  transition: 0.3s;
}
.text-scale-4 {
  font-size: 16px;
  transition: 0.3s;
}
.text-scale-4:hover {
  font-size: 18px;
  transition: 0.3s;
}
.hover-underline-animation {
  cursor: pointer;
  display: inline-block;
  position: relative;
  color: white;
}
.hover-underline-animation:hover {
  display: inline-block;
  position: relative;
  color: rgb(0, 197, 111);
}

.hover-underline-animation:after {
  content: '';
  position: absolute;
  width: 100%;
  transform: scaleX(0);
  height: 2px;
  bottom: 0;
  left: 0;
  background-color: #028700;
  transform-origin: bottom right;
  transition: transform 0.25s ease-out;
}

.hover-underline-animation:hover:after {
  transform: scaleX(1);
  transform-origin: bottom left;
}
</style>