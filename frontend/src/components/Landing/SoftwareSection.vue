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
              <h1 class="mb-2" style="font-size:30px">
                Começar
              </h1>
              <h1 class="font-weight-light">
                Clique aqui e acesse o sistema
              </h1>
              <v-btn
                rounded
                outlined
                to="/dashboard"
                large
                color="white"
                class="mt-4"
              >
                <v-icon class="mr-2"> mdi-laptop </v-icon>
                {{$store.state.software.name}}
              </v-btn>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
    </v-container>
  </section>
</template>

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
</style>