<template>
  <div>
    <v-main class="pt-0">
      <navigation />
      <home />
      <about />
      <software />
      <updates />
    </v-main>

    <v-tooltip left>
      <template v-slot:activator="{ attrs, on }">
        <v-scale-transition>
          <v-btn
            class=""
            v-bind="attrs"
            v-on="on"
            fab
            v-show="fab"
            v-scroll="onScroll"
            dark
            fixed
            bottom
            right
            @click="toTop"
          >
            <v-icon>mdi-arrow-up</v-icon>
          </v-btn>
        </v-scale-transition>
      </template>
      <span>Voltar para o topo</span>
    </v-tooltip>
  </div>
</template>

<script>
import navigation from '../components/Landing/NavigationSection';
import home from '../components/Landing/HomeSection';
import about from '../components/Landing/AboutSection';
import software from '../components/Landing/SoftwareSection';
import updates from '../components/Landing/UpdatesSection';
export default {
  name: 'App',

  components: {
    navigation,
    home,
    about,
    software,
    updates,
  },

  data: () => ({
    fab: null,
  }),

  created() {
  },


  methods: {
    onScroll(e) {
      if (typeof window === 'undefined') return;
      const top = window.pageYOffset || e.target.scrollTop || 0;
      this.fab = top > 60;
    },
    toTop() {
      this.$vuetify.goTo(0);
    },
  },
};
</script>
<style scoped>
.v-main {
  background-image: url('~@/assets/images/wallpapers/digital-1.jpg');
  background-attachment: fixed;
  background-position: center;
  background-size: cover;
}
.font-quicksand {
  font-family: 'Quicksand', sans-serif;
}
.bold {
  font-weight: bold;
}
.second_font-bold {
  font-family: 'Varela Round', sans-serif;
  font-weight: bold;
}
.second_font {
  font-family: 'Varela Round', sans-serif;
}
.bolder {
  font-weight: bolder;
}
.to-up-button {
  border-style: solid;
}
</style>
