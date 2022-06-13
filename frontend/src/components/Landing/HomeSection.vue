<template>
  <section id="home">
    <v-parallax dark src="@/assets/img/circuits1.jpg" height="750" alt="dasd">
      <v-row align="center" justify="center">
        <v-col cols="10">
          <v-row align="center" justify="center">
            <v-col cols="12" md="6" xl="8">
              <h1 style="font-size: 32px" class="font-quicksand">Bem-vindo</h1>
              <h1 class="font-weight-light">
                <span>Novas tecnologias feitas por nós, para nós</span>
                <br />
                <span>Sicoob Credisg - {{ new Date().getFullYear() }}</span>
                <br />
              </h1>
              <v-btn
                rounded
                outlined
                large
                dark
                @click="$vuetify.goTo('#features')"
                class="mt-5"
              >
                Me mostre
                <v-icon class="ml-2">mdi-arrow-down</v-icon>
              </v-btn>
              <div class="video d-flex align-center py-4">
                <a @click.stop="dialog = true" class="playBut">
                  <svg
                    version="1.1"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/"
                    x="0px"
                    y="0px"
                    width="60px"
                    height="60px"
                    viewBox="0 0 213.7 213.7"
                    enable-background="new 0 0 213.7 213.7"
                    xml:space="preserve"
                  >
                    <polygon
                      class="triangle"
                      id="XMLID_18_"
                      fill="none"
                      stroke-width="7"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-miterlimit="10"
                      points="73.5,62.5 148.5,105.8 73.5,149.1 "
                    />

                    <circle
                      class="circle"
                      id="XMLID_17_"
                      fill="none"
                      stroke-width="7"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-miterlimit="10"
                      cx="106.8"
                      cy="106.8"
                      r="103.3"
                    />
                  </svg>
                </a>
                <p class="subheading ml-2 mb-0">
                  Assista: Mais que uma escolha financeira
                </p>
              </div>
            </v-col>
            <v-col cols="12" md="6" xl="4" class="hidden-sm-and-down"> </v-col>
          </v-row>
        </v-col>
      </v-row>
      <div class="svg-border-waves text-white">
        <v-img src="@/assets/img/borderWaves.svg" />
      </div>
    </v-parallax>
    <v-container fluid id="features" class="mt-2">
      <v-row align="center" justify="center">
        <v-col cols="10">
          <v-row align="center" justify="space-around">
            <!--<v-col cols="12" class="text-center">
              <h1 class="font-weight-light display-2">Title</h1>
            </v-col>-->
            <v-col
              cols="12"
              sm="4"
              class="text-center"
              v-for="(feature, i) in features"
              :key="i"
            >
              <v-hover v-slot:default="{ hover }">
                <v-card
                  dark
                  class="card"
                  shaped
                  :elevation="hover ? 15 : 4"
                  :class="{ up: hover }"
                >
                  <v-img
                    :src="feature.img"
                    max-width="100px"
                    class="d-block ml-auto mr-auto"
                    :class="{ 'zoom-efect': hover }"
                  ></v-img>
                  <h2 class="mt-2">{{ feature.title }}</h2>
                  <h4 style="font-weight: 400">
                    {{ feature.text }}
                  </h4>
                </v-card>
              </v-hover>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
    </v-container>
    <v-dialog v-model="dialog" max-width="640px">
      <v-card color="rgba(8,110,95,.0)" class="ma-0 pa-0">
        <div style="height: 350px" v-if="player_loading">
          <v-img
            style="margin-left: auto; margin-right: auto; top: 130px"
            max-width="70"
            src="../../assets/images/loading.gif"
          ></v-img>
        </div>

        <youtube
          v-show="!player_loading"
          :video-id="videoId"
          @ready="ready"
          @playing="playing"
        ></youtube>
      </v-card>
    </v-dialog>
    <div class="svg-border-waves">
      <img src="~@/assets/img/wave2.svg" />
    </div>
  </section>
</template>

<script>
//console.log = function () {};
export default {
  data() {
    return {
      dialog: false,
      player_loading: true,
      videoId: '-V5b2vEKFtM',
      features: [
        {
          img: require('@/assets/images/web-security.png'),
          title: 'Mais Segurança',
          text: 'Sistema de criptografia implementado nos seus dados sensíveis e comunicação API Rest',
        },
        {
          img: require('@/assets/images/AI.png'),
          title: 'Nova Engenharia',
          text: 'Software desenvolvido em arquitetura Vue, Laravel, e muito mais.',
        },
        {
          img: require('@/assets/images/web-design.png'),
          title: 'Design Moderno',
          text: 'Interface interativa criada com muito capricho, só pra você.',
        },
      ],
    };
  },
  watch: {
    dialog(value) {
      if (!value) {
        this.player_loading = false;
        this.pause();
      }
    },
  },
  methods: {
    ready(event) {
      this.player = event.target;
      this.player_loading = false;
    },
    playing() {
      // The player is playing a video.
    },
    change() {
      // when you change the value, the player will also change.
      // If you would like to change `playerVars`, please change it before you change `videoId`.
      // If `playerVars.autoplay` is 1, `loadVideoById` will be called.
      // If `playerVars.autoplay` is 0, `cueVideoById` will be called.
      this.videoId = 'another video id';
    },
    stop() {
      this.player.stopVideo();
    },
    pause() {
      this.player.pauseVideo();
    },
  },
};
</script>

<style lang="scss">
.circle {
  stroke: white;
  stroke-dasharray: 650;
  stroke-dashoffset: 650;
  -webkit-transition: all 0.5s ease-in-out;
  opacity: 0.3;
}

.playBut {
  /*  border: 1px solid red;*/
  display: inline-block;
  -webkit-transition: all 0.5s ease;

  .triangle {
    -webkit-transition: all 0.7s ease-in-out;
    stroke-dasharray: 240;
    stroke-dashoffset: 480;
    stroke: white;
    transform: translateY(0);
  }

  &:hover {
    .triangle {
      stroke-dashoffset: 0;
      opacity: 1;
      stroke: white;
      animation: nudge 0.7s ease-in-out;

      @keyframes nudge {
        0% {
          transform: translateX(0);
        }
        30% {
          transform: translateX(-5px);
        }
        50% {
          transform: translateX(5px);
        }
        70% {
          transform: translateX(-2px);
        }
        100% {
          transform: translateX(0);
        }
      }
    }

    .circle {
      stroke-dashoffset: 0;
      opacity: 1;
    }
  }
}
</style>

<style>
.btn-play {
  transition: 0.2s;
}

.svg-border-waves .v-image {
  position: absolute;
  bottom: 0;
  left: 0;
  height: 5rem;
  width: 100%;
  overflow: hidden;
}

#hero {
  z-index: 0;
}
.svg-border-waves img {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  margin-bottom: -2px;
  z-index: -1;
}

.card {
  min-height: 300px;
  padding: 10px;
  transition: 0.5s ease-out;
  background-image: linear-gradient(
    to right,
    rgb(0, 0, 0),
    rgba(1, 16, 13, 0.814),
    rgba(0, 24, 68, 0.316)
  );
}

.card .v-image {
  margin-bottom: 15px;
  transition: 0.75s;
}

.card h2 {
  margin-bottom: 20px;
}

.zoom-efect {
  transform: scale(1.2);
}

.up {
  transform: translateY(-20px);
  transition: 0.5s ease-out;
}
</style>

<style>
section {
  position: relative;
}
</style>
