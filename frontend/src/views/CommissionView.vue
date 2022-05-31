<template>
  <div :class="margin">
    <commission-component></commission-component>
  </div>
</template>

<script>
import CommissionComponent from '../components/CommissionComponent.vue';

export default {
  name: 'CommissionView',

  components: {
    CommissionComponent,
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
