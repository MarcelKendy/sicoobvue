<template>
  <div>
    <v-card class="info-cards info-card-border" :dark="dark" elevation="0">
      <v-img class="bg-img" width="90" :src="bg_icon"></v-img>
      <span class="card-content info-cards-title" :class="dark ? 'text-shadow-black' : 'text-shadow-white'">{{ title }}</span>
      <span class="card-content info-cards-value value-gradient-green">{{ data }}</span>
      <span class="card-content info-cards-subtitle" :class="dark ? 'text-shadow-black' : 'text-shadow-white'">{{ subtitle }}</span>
      <span class="card-content footer" :class="dark ? 'text-shadow-black' : 'text-shadow-white'">{{ new Date().getFullYear() }}</span>
    </v-card>
  </div>
</template>

<script>
export default {
  props: ['data', 'title', 'subtitle', 'dark'],
  name: 'InfoCardsComponent',
  data: () => ({}),
  methods: {},
  computed: {
    bg_icon() {
      let bg = '';
      switch (this.title) {
        case 'Aguard. Venda':
          bg = require('@/assets/icons/waiting-sale.png');
          break;
        case 'Aguard. UPS':
          bg = require('@/assets/icons/ups.png');
          break;
        case 'Não Vendido':
          bg = require('@/assets/icons/not-sold.png');
          break;
        case 'Recusado UPS':
          bg = require('@/assets/icons/disapproved.png');
          break;
      }
      return bg;
    },
  },
};
</script>

<style>
.card-content {
  z-index: 2;
  position: absolute;
}
.info-cards {
  overflow: hidden;
  height: 120px;
  padding: 10px 10px 10px 10px;
}
.bg-img {
  z-index: 1;
  position: absolute;
  opacity: 0.7;
}
.info-cards-title {
  font-size: 22px;
  font-weight: bold;
}
.info-cards-subtitle {
  font-size: 14px;
  font-weight: bold;
  bottom: 10px;
  left: 10px;
}
.info-cards-value {
  font-weight: bold;
  font-size: 20px;
  right: 10px;
  -webkit-background-clip: text !important;
  background-clip: text !important;
  -webkit-text-fill-color: transparent;
}
.value-gradient-green {
  background: linear-gradient(to right, rgb(92, 246, 97), rgb(0, 98, 44));
}
.text-shadow-white {
  text-shadow: 1px 1px rgb(255, 255, 255);
}
.text-shadow-black {
  text-shadow: 1px 1px rgb(0, 0, 0);
}
.footer {
  font-size: 12px;
  font-weight: bold;
  bottom: 10px;
  right: 10px;
}
</style>
<style lang="scss">
.info-card-border {
  --angle: 0deg;

  border: 2px solid;
  border-image: conic-gradient(
      from var(--angle),
      rgb(253, 249, 1),
      rgb(10, 255, 2),
      rgb(121, 178, 253),
      rgba(18, 210, 175)
    )
    1;

  animation: 10s rotate linear infinite;
}

@keyframes rotate {
  to {
    --angle: 360deg;
  }
}

@property --angle {
  syntax: '<angle>';
  initial-value: 0deg;
  inherits: false;
}
</style>