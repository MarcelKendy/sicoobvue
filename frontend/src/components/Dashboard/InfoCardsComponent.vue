<template>
  <div>
    <v-slide-x-reverse-transition>
      <v-hover v-slot:default="{ hover }" v-show="show_animation">
        <div :class="{ up_info_cards: hover }" style="transition: 0.5s">
          <v-card
            :class="info_cards_classes"
            :dark="dark"
            :style="
              outlined
                ? dark
                  ? 'background-color: rgb(36, 38, 41);'
                  : 'background-color: rgb(238, 238, 238);'
                : ''
            "
          >
            <v-img class="bg-img" width="90" :src="bg_icon"></v-img>
            <span
              class="card-content info-cards-title"
              :class="outlined ? (dark ? 'text-shadow-black' : 'text-shadow-white') : ('text-shadow-black')"
              style="font-size: 22px"
              >{{ title }}</span
            >
            <span
              class="card-content info-cards-title"
              :class="outlined ? content_classes(1) : 'text-shadow-white'"
              >{{ title }}</span
            >
            <span :class="content_classes()">{{ data }}</span>
            <span
              class="card-content info-cards-subtitle"
              :class="
                outlined
                  ? dark
                    ? 'text-shadow-black'
                    : 'text-shadow-white'
                  : 'text-shadow-black'
              "
              >{{ subtitle }}</span
            >
            <span
              class="card-content footer"
              :class="dark ? 'text-shadow-black' : 'text-shadow-white'"
              >{{ new Date().getFullYear() }}</span
            >
          </v-card>
        </div>
      </v-hover>
    </v-slide-x-reverse-transition>
  </div>
</template>

<script>
export default {
  props: {
    data: {},
    title: {},
    subtitle: {},
    dark: {},
    delay: {},
    outlined: { type: [Boolean], default: false },
  },
  name: 'InfoCardsComponent',
  data: () => ({
    show_animation: false,
  }),
  created() {
    let _this = this;
    setTimeout(function () {
      _this.show_animation = true;
    }, this.delay * 1000);
  },
  methods: {
    content_classes(type = 0) {
      let classes =
        type == 0
          ? 'card-content info-cards-value '
          : 'card-content info-cards-title ';
      switch (this.title) {
        case 'Aguard. Venda':
          classes = classes.concat('value-gradient-blue');
          break;
        case 'Aguard. UPS':
          classes = classes.concat('value-gradient-orange');
          break;
        case 'Não Vendido':
          classes = classes.concat('value-gradient-gray');
          break;
        case 'Recusado UPS':
          classes = classes.concat('value-gradient-red');
          break;
      }
      return classes;
    },
  },
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
    info_cards_classes() {
      let classes = 'info-cards ';
      switch (this.title) {
        case 'Aguard. Venda':
          classes = this.outlined
            ? classes.concat('info-cards-border-blue')
            : classes.concat('info-cards-border-blue gradient-info-card-blue');
          break;
        case 'Aguard. UPS':
          classes = this.outlined
            ? classes.concat('info-cards-border-orange')
            : classes.concat(
                'info-cards-border-orange gradient-info-card-orange'
              );
          break;
        case 'Não Vendido':
          classes = this.outlined
            ? classes.concat('info-cards-border-gray')
            : classes.concat('info-cards-border-gray gradient-info-card-gray');
          break;
        case 'Recusado UPS':
          classes = this.outlined
            ? classes.concat('info-cards-border-red')
            : classes.concat('info-cards-border-red gradient-info-card-red');
          break;
      }
      return classes;
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
  box-shadow: rgba(0, 0, 0, 0.25) 0px 9px 8px,
    rgba(0, 0, 0, 0.22) 0px 0px 6px 0px !important;
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
  -webkit-background-clip: text !important;
  background-clip: text !important;
  -webkit-text-fill-color: transparent;
}

.info-cards-subtitle {
  font-size: 12px;
  font-weight: bold;
  bottom: 10px;
  left: 10px;
}

.info-cards-value {
  font-weight: bold;
  font-size: 30px;
  right: 10px;
  -webkit-background-clip: text !important;
  background-clip: text !important;
  -webkit-text-fill-color: transparent;
}


.text-shadow-black {
  color: white;
  text-shadow: 1px 1px rgb(0, 0, 0);
}

.text-shadow-white {
  color: rgb(0, 0, 0);
  text-shadow: 1px 1px rgb(255, 255, 255);
}

.footer {
  font-size: 12px;
  font-weight: bold;
  bottom: 10px;
  right: 10px;
}
</style>
<style lang="scss" scoped>
.info-cards-border {
  --angle: 0deg;

  border: 4px solid;
  border-image: conic-gradient(
      from var(--angle),
      rgb(253, 249, 1),
      rgb(10, 255, 2),
      rgb(121, 178, 253),
      rgba(18, 210, 175)
    )
    1;

  animation: 15s rotate linear infinite;
}

.info-cards-border-blue {
  --angle: 0deg;

  border: 4px solid;
  border-image: conic-gradient(
      from var(--angle),
      rgb(69, 0, 231),
      rgb(32, 75, 248),
      rgb(0, 110, 255),
      rgb(146, 220, 255)
    )
    1;

  animation: 15s rotate linear infinite;
}

.info-cards-border-orange {
  --angle: 0deg;

  border: 4px solid;
  border-image: conic-gradient(
      from var(--angle),
      rgb(222, 78, 0),
      rgb(214, 93, 0),
      rgb(255, 128, 0),
      rgb(255, 188, 134)
    )
    1;

  animation: 15s rotate linear infinite;
}

.info-cards-border-gray {
  --angle: 0deg;

  border: 4px solid;
  border-image: conic-gradient(
      from var(--angle),
      rgb(15, 63, 99),
      rgb(97, 108, 153),
      rgb(130, 132, 144),
      rgb(134, 166, 172)
    )
    1;

  animation: 15s rotate linear infinite;
}

.info-cards-border-red {
  --angle: 0deg;

  border: 4px solid;
  border-image: conic-gradient(
      from var(--angle),
      rgb(169, 34, 34),
      rgb(150, 33, 97),
      rgba(255, 0, 0, 0.765),
      rgb(255, 107, 121)
    )
    1;

  animation: 15s rotate linear infinite;
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