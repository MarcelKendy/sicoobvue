<template>
  <section id="about">
    <v-container fluid>
      <v-row align="center" justify="center">
        <v-col cols="10">
          <v-row align="center" justify="center">
            <v-col cols="12" md="7">
              <h1>
                <span class="text_gradient">Sobre</span>
                <v-img
                  max-width="24"
                  style="display: inline-block"
                  src="@/assets/icons/sicoobicon.png"
                ></v-img>
              </h1>
              <h1 class="font-weight-light mb-3">Ferramentas já idealizadas</h1>
              <v-row>
                <v-col cols="12" class="d-flex align-center">
                  <v-img
                    src="@/assets/images/home/dashboard.png"
                    max-width="60px"
                    class="mr-4"
                  />
                  <p class="text-justify">
                    <strong class="text_gradient">Dashboard de Metas</strong>
                    <br />
                    Através de uma dashboard moderna, será possível acompanhar o
                    nosso progresso das metas estabelecidas pela cooperativa.
                  </p>
                </v-col>
                <v-col cols="12" class="d-flex align-center">
                  <v-img
                    src="@/assets/images/home/commission.png"
                    max-width="60px"
                    class="mr-4"
                  />
                  <p class="text-justify">
                    <strong class="text_gradient"
                      >Sistema de Comissionamento</strong
                    >
                    <br />
                    A fim de proporcionar mais eficiência e segurança no
                    processo de comissionamento de produtos, foi desenvolvido
                    uma plataforma automatizada com muitos recursos.
                  </p>
                </v-col>
                <v-col cols="12" class="d-flex align-center">
                  <v-img
                    src="@/assets/images/home/adm.png"
                    max-width="60px"
                    class="mr-4"
                  />
                  <p class="text-justify">
                    <strong class="text_gradient">Gestão Completa</strong>
                    <br />
                    Ferramentas fáceis e eficientes para os administradores do
                    sistema.
                  </p>
                </v-col>
                <v-col cols="12" class="d-flex align-center">
                  <v-img
                    src="@/assets/images/home/up.png"
                    max-width="60px"
                    class="mr-4"
                  />
                  <p class="text-justify">
                    <strong class="text_gradient">Ao Infinito e Além</strong>
                    <br />
                    Nosso futuro é grande, e o do sistema também. Serão
                    anunciadas as novas implementações na seção "Updates", no
                    final da página ;)
                  </p>
                </v-col>
              </v-row>
            </v-col>
            <v-col cols="12" md="5" class="d-none d-md-flex">
              <v-img
                class="sicoob-mark"
                src="@/assets/images/home/sicoob-mark.png"
                style="position:absolute; top:0px; right: 0px; border-radius: 0 0 0 20px 20px"
                max-width="200px"
              ></v-img>
              <v-img
                src="@/assets/images/home/credisg.png"
                style="position:absolute; bottom:0px; right: 0px"
                max-width="400px"
              ></v-img>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
    </v-container>
  </section>
</template>

<style scoped>
#about {
  background-image: linear-gradient(
    to right,
    rgba(8, 10, 17, 0.664),
    rgba(0, 0, 0, 0.97),
    rgba(3, 12, 64, 0.878)
  );
  color: rgb(255, 255, 255);
}
.text_gradient {
  background: linear-gradient(to right, rgb(165, 213, 44), rgb(0, 82, 85));
  -webkit-background-clip: text;
  background-clip: text;
}

.sicoob-mark {
  background-color: linear-gradient(to right, rgb(165, 213, 44), rgb(0, 82, 85));
}
</style>
/* 
  background-image: linear-gradient(
    to right,
    rgba(8, 10, 17, 0.886),
    rgba(0, 0, 0, 0.97),
    rgba(3, 12, 64, 0.878)
  );

  background-image: linear-gradient(
    to right,
    rgba(3, 22, 72, 0.886),
    rgba(5, 64, 80, 0.97),
    rgba(3, 12, 64, 0.878)
  );

  background-image: linear-gradient(
    to right,
    rgba(0, 33, 43, 0.876),
    rgba(0, 47, 60, 0.202),
    rgba(0, 63, 81, 0.857)
  );
