<template>
  <section id="software">
    <v-container fluid>
      <v-row align="center" justify="center">
        <v-col cols="10">
          <v-row align="center" justify="center">
            <v-col sm="4" class="hidden-xs-only">
              <v-img
                src="@/assets/img/ill2.svg"
                class="d-block ml-auto mr-auto"
                max-width="350px"
              />
            </v-col>
            <v-col cols="12" sm="8" class="white--text text-left">
              <h1 class="mb-2" style="font-size: 30px">Começar</h1>
              <h1 class="font-weight-light">Clique aqui e acesse o sistema</h1>
              <v-btn
                rounded
                outlined
                :to="to"
                large
                color="white"
                class="btn btn-gradient btn-software"
              >
                <v-icon class="mr-2"> mdi-laptop </v-icon>
                Acessar
              </v-btn>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
    </v-container>
  </section>
</template>

<script>
import db from '@/services/localbase';
export default {
  data: () => ({
    to: '/login',
  }),
  mounted() {
    db.collection('user')
      .limit(1)
      .get()
      .then((user) => {
        if (!user.length) {
          this.to = '/login';
        } else {
          this.to = '/dashboard';
        }
      });
  },
};
</script>

<style scoped>
#software {
  background-image: url('~@/assets/img/bgDownload.jpg');
  background-attachment: fixed;
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
  height: 500px;
}

#software .container,
#software .row {
  height: 100%;
}
.btn-gradient {
  background-image: linear-gradient(
    to right,
    rgba(30, 200, 100, 0.1) 0%,
    rgba(89, 155, 241, 0.1) 51%,
    rgba(240, 212, 97, 0.1) 100%
  ) !important;
  background-position: left center; 
}
.btn-gradient:hover {
  transition: background-position 2s;
  background-image: linear-gradient(
    to right,
    rgba(30, 200, 100, 0.9) 0%,
    rgba(89, 155, 241, 0.9) 51%,
    rgba(240, 212, 97, 0.9) 100%
  ) !important;
  background-position: right center; /* change the direction of the change here */
}
</style>