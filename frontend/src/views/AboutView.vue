<template>
  <div :class="margin">
    <about-component />
  </div>
</template>

<script>
import AboutComponent from '../components/AboutComponent';

export default {
  name: 'AboutView',

  components: {
    AboutComponent,
  },
  methods: {
    margin_calculate() {
      switch (this.$vuetify.breakpoint.name) {
        case 'xs':
          return 'ma-2';
        case 'sm':
          return 'ma-5';
        case 'md':
          return 'ma-7';
        case 'lg':
          return 'ma-16';
        case 'xl':
          return 'ma-20';
        default:
          return 'ma-10';
      }
    },
  },
  computed: {
    margin() {
      return this.margin_calculate();
    },
  },
};
</script>
