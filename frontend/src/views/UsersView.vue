<template>
  <div class="ma-10">
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
};
</script>
