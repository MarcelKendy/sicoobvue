<template>
  <div>
    <v-row class="align-center">
      <v-col cols="12" sm="4">
        <v-card
          :shaped="hover_1"
          @mouseenter="hover_1 = !hover_1"
          @mouseleave="hover_1 = !hover_1"
          :class="dark_theme ? 'info-cards-dark' : 'info-cards'"
          class="gradient-card gradient-purple"
        >
          <v-card-title class="info-cards-text">
            Comissões aprovadas
          </v-card-title>
          <v-card-subtitle class="info-cards-text"
            >Últimas 4 semanas</v-card-subtitle
          >
          <v-card-text>
            <apex-chart
              type="line"
              height="100"
              :options="spark_done_commissions"
              :series="series_spark_done_commissions"
            ></apex-chart>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" sm="4">
        <v-card
          :shaped="hover_2"
          @mouseenter="hover_2 = !hover_2"
          @mouseleave="hover_2 = !hover_2"
          :class="dark_theme ? 'info-cards-dark' : 'info-cards'"
          class="gradient-card gradient-green"
        >
          <v-card-title class="info-cards-text"> INFO CARD 2 </v-card-title>
          <v-card-subtitle class="info-cards-text"> descricao </v-card-subtitle>
          <v-card-text> </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" sm="4">
        <v-card
          :shaped="hover_3"
          @mouseenter="hover_3 = !hover_3"
          @mouseleave="hover_3 = !hover_3"
          :class="dark_theme ? 'info-cards-dark' : 'info-cards'"
          class="gradient-card gradient-orange"
        >
          <v-card-title class="info-cards-text"> INFO CARD 3 </v-card-title>
          <v-card-subtitle class="info-cards-text"> descricao </v-card-subtitle>
          <v-card-text> </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <v-row class="align-center">
      <v-col cols="12" md="6">
        <v-card :dark="dark_theme">
          <v-card-title> GRAFICO 1 </v-card-title>
          <v-card-subtitle> descricao </v-card-subtitle>
          <v-card-text> </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" md="6">
        <v-card :dark="dark_theme">
          <v-card-title> GRAFICO 2 </v-card-title>
          <v-card-subtitle> descricao </v-card-subtitle>
          <v-card-text> </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script>
export default {
  name: 'DashboardComponent',

  data: () => ({
    hover_1: false,
    hover_2: false,
    hover_3: false,
    loading_card_done_commissions: false,
    loading_card_2: false,
    loading_card_3: false,
    series_spark_done_commissions: [
      {
        name: 'spark_done_commissions',
        data: [0, 1, 2, 3],
      },
    ],
    spark_done_commissions: {
      chart: {
        sparkline: {
          enabled: true,
        },
        dropShadow: {
          enabled: true,
          top: 8,
          left: 8,
          blur: 2,
          opacity: 0.2,
        },
      },
      stroke: {
        curve: 'smooth',
      },
      xaxis: {
        categories: [
          '1',
          '2',
          '3',
          '4',
        ],
        tickAmount: 4,
        labels: {
          formatter: function (value) {
            /*let date = String (value);
            let day_month = date.slice(5, 10);
            let day = day_month.slice(3);
            let month = day_month.slice(0, 2);
            return day + '/' + month;*/
            let date = new Date() - value * 7;
            
            
            return new Date(date).getTime();
          },
        },
      },
      markers: {
        size: 0,
      },
      grid: {},
      colors: ['#fff'],
      tooltip: {
        x: {
          show: true,
        },
        y: {
          title: {
            formatter: function formatter() {
              return '';
            },
          },
        },
      },
    },
  }),
  created() {
    this.getCards();
  },
  computed: {
    dark_theme() {
      try {
        return this.$store.state.user.configs.theme == 0;
      } catch (err) {
        return false;
      }
    },
  },
  methods: {
    getCards() {
      this.loading_card_done_commissions = true;
      this.$http.get('get_card_done_commissions').then((response) => {
        console.log(response.data);
        this.loading_card_done_commissions = false;
      });
    },
    formatDate(date, type) {
      if (type == 'd_m') {
        let day_month = date.slice(5, 10);
        let day = day_month.slice(3);
        let month = day_month.slice(0, 2);
        return day + '/' + month;
      }
      if (type == 'y') {
        return date.slice(0, 4);
      }
    },
  },
};
</script>
<style scoped>
.info-cards {
  border-radius: 15px;

  transition: 0.3s;
}
.info-cards:hover {
  box-shadow: rgba(0, 0, 0, 0.25) 0px 14px 28px,
    rgba(0, 0, 0, 0.22) 0px 10px 10px !important;
  transition: 0.3s;
}
.info-cards-dark {
  border-radius: 15px;

  transition: 0.3s;
}
.info-cards-dark:hover {
  box-shadow: rgb(0, 0, 0) 0px 14px 18px, rgb(0, 0, 0) 10px 7px 10px !important;
  transition: 0.3s;
}
.info-cards-text {
  font-family: 'Quicksand', sans-serif;
  color: white !important;
  font-weight: bold !important;
}
</style>
/*
.info-cards {
  border-radius: 10px;
  box-shadow: rgba(0, 0, 0, 0.4) 8px 5px 4px, rgba(0, 0, 0, 0.3) 0px 10px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset !important;
}
.info-cards-dark {
  border-radius: 10px;
  box-shadow: rgba(84, 84, 84, 0.684) 8px 5px 4px, rgba(93, 93, 93, 0.25) 0px 10px 13px -3px, rgba(0, 0, 0, 0.467) 0px -3px 0px inset !important;
}
box-shadow: rgba(0, 0, 0, 0.17) 0px -1px 0px 0px inset, rgba(0, 0, 0, 0.15) 0px -6px 10px 0px inset, rgba(0, 0, 0, 0.1) 0px 0px 0px 0px inset, rgba(0, 0, 0, 0.156) 6px 8px 3px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 1px 0px, rgba(0, 0, 0, 0.09) 0px 0px 0px, rgba(0, 0, 0, 0.09) 0px 0px 0px !important;