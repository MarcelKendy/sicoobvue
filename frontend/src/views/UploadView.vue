<template>
  <div :class="margin">
    <upload-component />
  </div>
</template>

<script>
import UploadComponent from '../components/UploadComponent';

export default {
  name: 'UploadView',

  components: {
    UploadComponent,
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
          return 'ma-14';
        case 'xl':
          return 'ma-16';
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
