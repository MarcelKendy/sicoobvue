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
              <v-hover v-slot="{ hover }">
                <v-btn
                  rounded
                  outlined
                  :to="to"
                  large
                  color="white"
                  class="neon-button my-6"
                >
                  <v-img
                    class="mr-2"
                    max-width="24"
                    :src="
                      require(!hover
                        ? '@/assets/img/power-button-green.png'
                        : '@/assets/img/power-button.png')
                    "
                  ></v-img>
                  <strong>Entrar</strong>
                </v-btn>
              </v-hover>
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
    to: '/login',
  }),
  mounted() {
    db.collection('user')
      .limit(1)
      .get()
      .then((user) => {
        if (!user.length) {
          this.to = '/login';
        } else {
          this.to = '/dashboard';
        }
      });
  },
};
</script>

<style scoped>
#software {
  opacity: 1;
  background-image: url('~@/assets/img/bghero2.jpg');
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
</style>
<style scoped>
.neon-button {
  width: 150px;
  height: 50px;
  border: none;
  outline: none;
  color: #fff;
  background: #111;
  cursor: pointer;
  position: relative;
  z-index: 0;
  border-radius: 10px;
}

.neon-button:before {
  content: '';
  background: linear-gradient(
    45deg,
    #ff0000,
    #ff7300,
    #fffb00,
    #48ff00,
    #00ffd5,
    #002bff,
    #7a00ff,
    #ff00c8,
    #ff0000
  );
  position: absolute;
  top: -2px;
  left: -2px;
  background-size: 400%;
  z-index: -1;
  filter: blur(5px);
  width: calc(100% + 4px);
  height: calc(100% + 4px);
  animation: glowing 20s linear infinite;
  opacity: 0.3;
  transition: opacity 0.3s ease-in-out;
  border-radius: 10px;
}

.neon-button:active {
  color: #000;
}

.neon-button:active:after {
  background: transparent;
}

.neon-button:hover:before {
  opacity: 1;
}

.neon-button:after {
  z-index: -1;
  content: '';
  position: absolute;
  width: 100%;
  height: 100%;
  background: #111;
  left: 0;
  top: 0;
  border-radius: 10px;
}

@keyframes glowing {
  0% {
    background-position: 0 0;
  }
  50% {
    background-position: 400% 0;
  }
  100% {
    background-position: 0 0;
  }
}
</style>