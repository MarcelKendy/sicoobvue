<template>
  <section id="about">
    <v-container fluid>
      <v-row align="center" justify="center">
        <v-col cols="10">
          <v-row align="center" justify="center">
            <v-col cols="12" md="7">
              <h1 class="second_font">Sobre</h1>
              <h1 class="font-weight-light mb-3">
                Ferramentas já idealizadas
              </h1>
              <v-row>
                <v-col cols="12" class="d-flex align-center">
                  <v-img
                    src="@/assets/img/icon2.svg"
                    max-width="60px"
                    class="mr-4"
                  />
                  <p class="text-justify">
                    <strong>Dashboard de Metas</strong>
                    <br>
                    Será possível acompanhar através de uma dashboard moderna, o nosso progresso das metas estabelecidas pela cooperativa. 
                  </p>
                </v-col>
                <v-col cols="12" class="d-flex align-center">
                  <v-img
                    src="@/assets/img/icon1.svg"
                    max-width="60px"
                    class="mr-4"
                  />
                  <p class="text-justify">
                    <strong>Sistema de Comissionamento</strong>
                    <br>
                    A fim de proporcionar mais eficiência e segurânca no processo de comissionamento de produtos, foi desenvolvido uma plataforma automatizada com muitos recursos.
                  </p>
                </v-col>
                <v-col cols="12" class="d-flex align-center">
                  <v-img
                    src="@/assets/img/icon3.svg"
                    max-width="60px"
                    class="mr-4"
                  />
                 <p class="text-justify">
                    <strong>Gestão Completa</strong>
                    <br>
                    Uma administração fácil e eficiente, relatórios bem aplicados, data mining e muito mais.
                  </p>
                </v-col>
                <v-col cols="12" class="d-flex align-center">
                  <v-img
                    src="@/assets/img/icon3.svg"
                    max-width="60px"
                    class="mr-4"
                  />
                 <p class="text-justify">
                    <strong>Muito Mais</strong>
                    <br>
                    Nosso futuro é grande, e o do sistema também. Serão anunciadas as novas implementações aqui ;)
                  </p>
                </v-col>
              </v-row>
            </v-col>
            <v-col cols="12" md="5" class="d-none d-md-flex">
              <v-img
                src="@/assets/img/ill1.svg"
                class="d-block ml-auto mr-auto"
                max-width="400px"
              />
            </v-col>
          </v-row>
        </v-col>
      </v-row>
    </v-container>
  </section>
</template>

<style scoped>
#about {
  background-color: #f4f7f5;
}
</style>
