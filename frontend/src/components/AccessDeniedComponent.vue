<template>
  <v-row>
    <v-col align="center" cols="12">
      <v-card dark max-width="1200">
        <v-card-title class="justify-center">
          <span>Epa epa... Aqui não pode!</span><v-img max-width="32" class="mx-3 mb-2" src="./../assets/icons/bots/bot1/bot-question.png"></v-img>
        </v-card-title>
        <v-card-subtitle class="justify-center">
          <span class="red--text">Acesso Negado</span>
        </v-card-subtitle>
        <v-card-text>
          <v-alert :color="color" border="left" elevation="7" dark prominent>
            <template slot="prepend">
              <v-img
                width="150px"
                src="./../assets/images/access-denied.png"
              ></v-img>
            </template>
            <h3>Caro usuário, a rota que você tentou acessar requer um acesso que você não possui.</h3>
            <p class="mt-2">Caso tenha sido por acidente, verifique a rota e clique no botão abaixo.</p>
            <p class="mt-1"> Caso queira esse acesso, contate um <strong>ADM</strong> do sistema.</p>
            <p class="mt-1 bold">PS: Se já lhe foi concedido o acesso, é necessário relogar no sistema.</p>
            <p class="mt-2">Dessa vez eu te perdoo! <v-img max-width="32" src="./../assets/icons/bots/bot1/bot-happy.png"></v-img></p>
            <v-divider></v-divider>
            <span class="font-weight-bold mt-3 font-italic">Dúvidas? Ramal: 1506 </span>
          </v-alert>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn to="/" class="gradient-success bold" 
            >Me levar pra casa<v-img
              src="./../assets/icons/landing-page.png"
            ></v-img
          ></v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: 'AccessDeniedComponent',

  data: () => ({
    color: 'red',
  }),
};
</script>
