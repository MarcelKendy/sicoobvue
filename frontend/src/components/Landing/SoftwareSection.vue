<template>
  <section id="software">
    <v-container fluid>
      <v-row align="center" justify="center">
        <v-col cols="10">
          <v-row align="center" justify="center">
            <v-col sm="4" class="hidden-xs-only">
              <v-img
                src="@/assets/img/computer.png"
                class="d-block ml-auto mr-auto"
                max-width="350px"
              />
            </v-col>
            <v-col cols="12" sm="8" class="white--text text-left pl-10">
              <span class="mb-2 begin bold">Acesso</span>
              <h3 class="font-weight-light">Clique aqui e acesse o sistema</h3>
              <v-btn
                rounded
                outlined
                large
                v-on:mouseenter="hoverBtn()"
                v-on:mouseleave="leaveBtn()"
                color="white"
                class="neon-button my-6"
                :class="{ increase_size: delayed_leave }"
                @click="redirectUser()"
              >
                <v-img
                  max-width="24"
                  class="icon"
                  :src="require('@/assets/img/power-button-green.png')"
                ></v-img>
                <v-slide-x-transition>
                  <strong v-if="delayed_hover" class="text_gradient"
                    >Entrar</strong
                  >
                </v-slide-x-transition>
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
    delayed_hover: false,
    delayed_leave: false,
    hover_timeout_id: null,
    hover_timeout_active: false,
  }),
  mounted() {},
  methods: {
    redirectUser() {
      db.collection('user')
        .limit(1)
        .get()
        .then((user) => {
          if (!user.length) {
            this.$router.push('/login');
          } else {
            this.$router.push('/dashboard');
          }
        });
    },
    hoverBtn() {
      this.delayed_leave = true;
      let _this = this;
      this.hover_timeout_active = true;
      this.hover_timeout_id = setTimeout(function () {
        _this.delayed_hover = true;
        _this.hover_timeout_active = false;
      }, 100);
    },
    leaveBtn() {
      if (this.hover_timeout_active) {
        clearTimeout(this.hover_timeout_id);
      }
      this.delayed_hover = false;
      let _this = this;
      setTimeout(function () {
        _this.delayed_leave = false;
      }, 130);
    },
  },
};
</script>

<style scoped>
#software {
  opacity: 1;
  background-image: url('~@/assets/img/sicoob-city.jpg');
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

.begin {
  transition: 0.5s;
  font-size: 28px;
}

.text_gradient {
  position: absolute;
  right: 3px;
  background: linear-gradient(to right, rgb(210, 246, 92), rgb(0, 96, 84));
  -webkit-background-clip: text;
  background-clip: text;
}

.increase_size {
  transition: 0.1s;
  width: 150px;
}

.icon {
  position: absolute;
  left: 10px;
}
</style>
