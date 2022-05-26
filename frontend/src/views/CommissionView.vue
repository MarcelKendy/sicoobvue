<template>
  <div class="ma-10">
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
};
</script>
