<template>
 
<v-footer
    dark
    padless
  >
    <v-card
      class="flex"
      flat
      tile
    >
     <v-img src="../assets/images/credisgbuilding2.png" gradient="to bottom left, rgba(173,12,227,.5), rgba(0,260,145,.6)" dark class="pt-5 text-center" max-height="82">
        <v-btn
          v-for="item in items"
          :key="item.destination"
          class="mx-4 white--text"
          icon
          target="_blank"
          :href="item.destination"
        >
          <v-icon size="24px">
            {{ item.icon }}
          </v-icon>
        </v-btn>   
        
    </v-img> 
    <v-card-text class="py-2 white--text text-center">
        {{ new Date().getFullYear() }} — <strong>Sicoob Credisg TI</strong> — São Gotardo/MG
    </v-card-text>
  </v-card>
</v-footer>
</template>

<script>
  export default {
    name: 'FooterComponent',

    data: () => ({
      items: [
        {icon: 'mdi-instagram', destination: 'https://www.instagram.com/marcelhwoarang/' },
        {icon: 'mdi-linkedin',  destination: 'https://www.linkedin.com/in/marcel-kendy-2550bb161/' },
        {icon: 'mdi-youtube',   destination: 'https://www.youtube.com/channel/UC0LF3UtqkFfRKmpz8N0JsdA' },
        {icon: 'mdi-facebook',  destination: 'https://www.facebook.com/marcelkendy' },
      ],
    }),
  }
</script>
