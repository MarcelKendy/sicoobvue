<template>
  <div :class="margin">
    <profile-component />
  </div>
</template>

<script>
import ProfileComponent from '../components/ProfileComponent';

export default {
  name: 'ProfileView',
  components: {
    ProfileComponent,
  },
  methods: {
    margin_calculate() {
      switch (this.$vuetify.breakpoint.name) {
        case 'xs':
          return 'ma-1';
        case 'sm':
          return 'ma-2';
        case 'md':
          return 'ma-3';
        case 'lg':
          return 'ma-5';
        case 'xl':
          return 'ma-14';
        default:
          return 'ma-8';
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
