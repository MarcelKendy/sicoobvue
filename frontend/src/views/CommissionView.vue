<template>
  <div>
    <v-container>
      <commission-component></commission-component>
    </v-container>
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
