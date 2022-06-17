<template>
  <div>
    <v-img
      class="bg"
      :src="wallpapers"
      lazy-src="@/assets/images/login_wallpapers/lazy.jpg"
    ></v-img>
    <div class="content">
      <v-btn dark small class="neon-button-filled" to="/"
        ><v-icon left>mdi-home</v-icon><span class="bold">Home</span></v-btn
      >
      <vue-particles
        color="#ffffff"
        :particleOpacity="0.7"
        :particlesNumber="60"
        shapeType="triangle"
        :particleSize="4"
        linesColor="#ffffff"
        :linesWidth="1"
        :lineLinked="true"
        :lineOpacity="0.4"
        :linesDistance="150"
        :moveSpeed="1"
        :hoverEffect="true"
        hoverMode="grab"
        :clickEffect="true"
        clickMode="push"
      ></vue-particles>
      <card-welcome-component />
      <div class="date-time-div">
        <span class="date-time">{{ datetime_reactive }}</span>
      </div>
      <login-component />
    </div>
  </div>
</template>


<script>
import LoginComponent from '../components/LoginComponent';
import CardWelcomeComponent from '../components/CardWelcomeComponent';

export default {
  name: 'LoginView',
  data: () => ({
    datetime_reactive: '',
    image: '',
  }),
  components: {
    LoginComponent,
    CardWelcomeComponent,
  },
  mounted: function () {
    let image_name = '';
    window.setInterval(() => {
      this.datetime_reactive = this.returnDateTime();
    }, 1000);
    image_name = this.getRandomInt(1, 5);
    this.image = image_name + '.jpg';
    window.setInterval(() => {
      image_name = this.getRandomInt(1, 5, image_name);
      this.image = image_name + '.jpg';
    }, 30000);
  },
  methods: {
    getRandomInt(min, max, previous) {
      min = Math.ceil(min);
      max = Math.floor(max);
      let temp = Math.floor(Math.random() * (max - min)) + min;
      if (temp == previous) {
        return this.getRandomInt(min, max, previous);
      } else {
        return temp;
      }
    },
    returnDateTime() {
      let data = new Date();

      // Guarda cada pedaço em uma letiável
      let dia = data.getDate(); // 1-31
      //let dia_sem = data.getDay();            // 0-6 (zero=domingo)
      let mes = data.getMonth(); // 0-11 (zero=janeiro)
      //let ano2    = data.getYear();           // 2 dígitos
      let ano4 = data.getFullYear(); // 4 dígitos
      let hora = data.getHours(); // 0-23
      let min = data.getMinutes(); // 0-59
      let seg = data.getSeconds(); // 0-59
      // let mseg    = data.getMilliseconds();   // 0-999
      //let tz      = data.getTimezoneOffset(); // em minutos

      // Formata a data e a hora (note o mês + 1)
      let str_data = dia + '/' + (mes + 1) + '/' + ano4;
      let str_hora = hora + ':' + min + ':' + seg;

      // Mostra o resultado
      return str_data + ' às ' + str_hora;
    },
  },
  computed: {
    wallpapers() {
      try {
        return require('@/assets/images/login_wallpapers/' + this.image);
      } catch {
        return '';
      }
    },
  },
};
</script>

<style>
.bg {
  filter: brightness(70%);
  position: relative;
  overflow: hidden;
  width: 100%;
  height: 100%;
  position: absolute;
  top: 0;
  left: 0;
  background: no-repeat center center;
  background-size: cover;
  transform: scale(1.1);
}
.bg-rainbow {
  overflow: hidden;
  background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
  background-size: 400% 400%;
  animation: gradient 15s ease infinite;
  height: 100vh;
}
.content {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
}
.date-time-div {
  position: absolute;
  bottom: 20px;
  right: 25px;
  font-family: 'Quicksand', sans-serif;
  color: white;
}
.date-time {
  font-weight: bolder;
  font-size: 12px;
}
</style>
<style lang="scss">
@keyframes gradient {
  0% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
  100% {
    background-position: 0% 50%;
  }
}
</style>
