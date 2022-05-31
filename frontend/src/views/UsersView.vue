<template>
  <div :class="margin">
    <users-component />
  </div>
</template>

<script>
import UsersComponent from '../components/UsersComponent';

export default {
  name: 'UsersView',

  components: {
    UsersComponent,
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
