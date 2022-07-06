<template>
  <section id="updates" class="pb-8">
    <v-container fluid>
      <v-row align="center" justify="center">
        <v-col cols="10">
          <v-card style="width: 100%" dark class="hover-card bold">
            <v-card-title style="background-color: rgba(10, 100, 100, 0.4)"
              ><v-img
                max-width="36"
                class="mr-5"
                src="./../../assets/icons/newspaper.png"
              ></v-img>
              <h2 class="title-card">Updates<strong class="mx-5" style="font-size:18px">(Log de Desenvolvimento)</strong></h2>
              <span style="position: absolute; right: 15px"
                >Até {{
                  new Date()
                    .toLocaleString('pt', { month: 'long' })
                    .toUpperCase()
                }}
                de {{ new Date().getFullYear() }}</span
              >
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
              <v-list v-if="news.length > 0">
                <v-list-item
                  two-line
                  v-for="(item, index) in news"
                  :key="index"
                  class="list-item-dark mt-2"
                >
                  <v-tooltip top :color="dark_theme ? 'grey darken-3' : ''">
                    <template v-slot:activator="{ attrs, on }">
                      <v-img
                        v-bind="attrs"
                        v-on="on"
                        max-width="32"
                        class="mr-5"
                        :src="require(item.type == 1 ? './../../assets/icons/info.png' : './../../assets/icons/alert.png')"
                      ></v-img>
                    </template>
                    <span>{{item.type == 2 ? 'ALERTA' : 'INFORMATIVO'}}</span>
                  </v-tooltip>

                  <v-list-item-content>
                    <h3>
                      {{ item.title }}
                      <span
                        class="mx-5"
                        style="position: absolute; right: 5px; font-size: 14px"
                        >{{ item.date }}</span
                      >
                    </h3>
                    <v-list-item-subtitle v-if="item.content">
                      <span>{{ item.content }}</span>
                    </v-list-item-subtitle>
                  </v-list-item-content>
                </v-list-item>
              </v-list>
              <v-list-item v-else class="list-item-dark">
               <span style="margin-left:auto; margin-right:auto"> Sem atualizações registradas nesse mês até o momento</span>
              </v-list-item>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </section>
</template>

<style lang="scss">
$main_color: #283e79;

ul {
  font-size: 13px;
  line-height: 1.5em;
  margin: 5px 0 15px;
  padding: 0;

  li {
    list-style: none;
    position: relative;
    padding: 0 0 0 20px;
  }

  li {
    &::before {
      content: '';
      position: absolute;
      left: 0;
      top: 5px;
      width: 10px;
      height: 10px;
      background-color: $main_color;
      border-radius: 50%;
      -moz-border-radius: 50%;
      -webkit-eeborder-radius: 50%;
    }
  }
}
</style>

<style scoped>
.header {
  background-color: #283e79;
  color: white;
}

.circle1 {
  border-radius: 50%;
  width: 150px;
  height: 150px;
  background-color: #f0f8ff;
  display: flex;
  align-items: center;
  justify-content: center;
}

.circle2 {
  border-radius: 50%;
  width: 100px;
  height: 100px;
  background-color: #e0effc;
  display: flex;
  align-items: center;
  justify-content: center;
}

.flex-center {
  display: flex;
  align-items: center;
  justify-content: center;
}

.svg-border-rounded svg {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  color: #f4f7f5;
  z-index: -1;
}

#pricing {
  z-index: 0;
}

.content {
  z-index: 1;
}

svg {
  overflow: hidden;
}

section {
  position: relative;
}
</style>

<script>
export default {
  data: () => ({
    news: [],
    loading_news: false
  }),
  created () {
    this.getSoftwareUpdates()
  },
  methods: {
    getSoftwareUpdates () {
      this.loading_news = true;
      this.$http.get('get_software_updates').then((response) => {
        this.news = response.data;
        this.loading_news = false;
      });
    }
  }
};
</script>