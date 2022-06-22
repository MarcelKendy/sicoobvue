<template>
  <div>
    <v-row class="align-center">
      <v-col cols="12" sm="4">
        <spark-component
          :options="spark_done_products"
          :series="series_spark_done_products"
          :total="total_spark_done_products"
          :loading="loading_card_done_products"
          :dark_theme="dark_theme"
          gradient="purple"
          title="Produtos Aprovados"
          subtitle="Spark Quadrimestral"
          loading_color="#75049b"
        ></spark-component>
      </v-col>
      <v-col cols="12" sm="4">
        <spark-component
          :options="spark_commissions_val"
          :series="series_spark_commissions_val"
          :total="total_spark_commissions_val"
          :loading="loading_card_commissions_val"
          :dark_theme="dark_theme"
          gradient="blue"
          title="Comissionamento R$"
          subtitle="Spark Quadrimestral"
          loading_color="#0066c5"
        ></spark-component>
      </v-col>
      <v-col cols="12" sm="4">
        <spark-component
          :options="spark_products_registers"
          :series="series_spark_products_registers"
          :total="total_spark_products_registers"
          :loading="loading_card_products_registers"
          :dark_theme="dark_theme"
          gradient="orange"
          title="Produtos Cadastrados"
          subtitle="Spark Quadrimestral"
          loading_color="#db2e4b"
        ></spark-component>
      </v-col>
    </v-row>
    <v-row class="align-center">
      <v-col
        cols="12"
        sm="3"
        v-for="info_card in info_cards_data"
        :key="info_card.status"
      >
        <info-cards-component
          :title="info_card.status"
          subtitle=""
          :data="info_card.qtt"
          :dark="dark_theme"
        ></info-cards-component>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import SparkComponent from './Dashboard/SparkComponent.vue';
import InfoCardsComponent from './Dashboard/InfoCardsComponent.vue';
export default {
  name: 'DashboardComponent',
  components: {
    SparkComponent,
    InfoCardsComponent,
  },
  data: () => ({
    info_cards_data: {},
    loading_card_done_products: true,
    loading_card_commissions_val: true,
    loading_card_products_registers: true,
    total_spark_done_products: 0,
    total_spark_commissions_val: 0,
    total_spark_products_registers: 0,
    series_spark_done_products: [
      {
        name: 'spark_done_products',
        data: [],
      },
    ],
    spark_done_products: {
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
        categories: [],
        tickAmount: 4,
        labels: {
          formatter: function (value) {
            return value;
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
          formatter: function (value) {
            return (
              '<div class="mr-6">' +
              '<span style="color:black">' +
              value +
              '</span>' +
              '</div>'
            );
          },
        },
      },
    },
    series_spark_commissions_val: [
      {
        name: 'spark_commissions_val',
        data: [],
      },
    ],
    spark_commissions_val: {
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
        categories: [],
        tickAmount: 4,
        labels: {
          formatter: function (value) {
            return value;
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
          formatter: function (value) {
            return (
              '<div style="position:absolute; left:12px; top:43px">' +
              '<span style="color:black">' +
              'R$ ' +
              value +
              '</span>' +
              '</div>'
            );
          },
        },
      },
    },
    series_spark_products_registers: [
      {
        name: 'spark_products_registers',
        data: [],
      },
    ],
    spark_products_registers: {
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
          formatter: function (value) {
            return (
              '<div class="mr-6" style="text-align:center !important">' +
              '<span style="color:black">' +
              value +
              '</span>' +
              '</div>'
            );
          },
        },
      },
      xaxis: {
        categories: [],
        tickAmount: 4,
        labels: {
          formatter: function (value) {
            return value;
          },
        },
      },
      markers: {
        size: 0,
      },
      grid: {},
      colors: ['#fff'],
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
      this.$http.get('get_info_cards').then((response) => {
        this.info_cards_data = response.data;
      });
      this.getSparkCards();
    },
    getSparkCards() {
      this.$http.get('get_card_done_products').then((response) => {
        this.series_spark_done_products[0].data = response.data[0];
        this.spark_done_products.xaxis.categories = response.data[1];
        this.total_spark_done_products = response.data[2];
        this.loading_card_done_products = false;
      });
      this.$http.get('get_card_commissions_val').then((response) => {
        this.series_spark_commissions_val[0].data = response.data[0];
        this.spark_commissions_val.xaxis.categories = response.data[1];
        this.total_spark_commissions_val = response.data[2];
        this.loading_card_commissions_val = false;
      });
      this.$http.get('get_card_products_registers').then((response) => {
        this.series_spark_products_registers[0].data = response.data[0];
        this.spark_products_registers.xaxis.categories = response.data[1];
        this.total_spark_products_registers = response.data[2];
        this.loading_card_products_registers = false;
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
<style>
.apexcharts-tooltip {
  width: 80px;
}

.apexcharts-tooltip-title {
  background-color: #b5b5b5 !important;
  color: #ffffff;
}
.total-text {
  font-family: 'Work Sans', sans-serif;
  font-weight: 500;
  text-shadow: 0.5px 0.5px rgba(0, 0, 0, 0.516);
}
</style>
/*
.spark-cards {
  border-radius: 10px;
  box-shadow: rgba(0, 0, 0, 0.4) 8px 5px 4px, rgba(0, 0, 0, 0.3) 0px 10px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset !important;
}
.spark-cards-dark {
  border-radius: 10px;
  box-shadow: rgba(84, 84, 84, 0.684) 8px 5px 4px, rgba(93, 93, 93, 0.25) 0px 10px 13px -3px, rgba(0, 0, 0, 0.467) 0px -3px 0px inset !important;
}
box-shadow: rgba(0, 0, 0, 0.17) 0px -1px 0px 0px inset, rgba(0, 0, 0, 0.15) 0px -6px 10px 0px inset, rgba(0, 0, 0, 0.1) 0px 0px 0px 0px inset, rgba(0, 0, 0, 0.156) 6px 8px 3px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 1px 0px, rgba(0, 0, 0, 0.09) 0px 0px 0px, rgba(0, 0, 0, 0.09) 0px 0px 0px !important;