<template>
  <div>
    <v-row class="align-center my-5">
      <v-col
        cols="12"
        sm="3"
        v-for="info_card in info_cards_data"
        :key="info_card.status"
      >
        <v-hover v-slot:default="{ hover }">
          <info-cards-component
            :outlined="!hover"
            :title="info_card.status"
            subtitle="Total"
            :data="info_card.qtt"
            :dark="dark_theme"
            :delay="info_card.delay"
          ></info-cards-component>
        </v-hover>
      </v-col>
    </v-row>
    <v-row class="align-center my-5">
      <v-col cols="12" sm="4">
        <spark-component
          :options="spark_done_products"
          :series="series_spark_done_products"
          :total="total_spark_done_products"
          :loading="loading_card_done_products"
          :dark_theme="dark_theme"
          gradient="green"
          title="Produtos Aprovados"
          subtitle="Spark Line Quadrimestral"
          loading_color="rgb(25, 73, 19)"
        ></spark-component>
      </v-col>
      <v-col cols="12" sm="4">
        <spark-component
          :options="spark_commissions_val"
          :series="series_spark_commissions_val"
          :total="total_spark_commissions_val"
          :loading="loading_card_commissions_val"
          :dark_theme="dark_theme"
          gradient="teal"
          title="Comissionamento R$"
          subtitle="Spark Line Quadrimestral"
          loading_color="rgb(0, 70, 103)"
        ></spark-component>
      </v-col>
      <v-col cols="12" sm="4">
        <spark-component
          :options="spark_products_registers"
          :series="series_spark_products_registers"
          :total="total_spark_products_registers"
          :loading="loading_card_products_registers"
          :dark_theme="dark_theme"
          gradient="purple"
          title="Produtos Cadastrados"
          subtitle="Spark Line Quadrimestral"
          loading_color="purple"
        ></spark-component>
      </v-col>
    </v-row>
    <v-row class="align-center my-5">
      <v-col cols="12" md="6">
        <graphs-card-component
          title="Produtos Efetivados"
          subtitle="Pie Chart em frequência relativa e absoluta"
          type="pie"
          color="rgb(85, 173, 29)"
          height="590"
          graph_width="580"
          icon="mdi-store"
          :loading="loading_pie_chart_products"
          :options="pie_products_percentage"
          :series="series_pie_products_percentage"
          :total="total_pie_chart_products"
          no_data_image="pie-chart.png"
          no_data_text="Não existem produtos aprovados"
          no_data_alert_color="green"
          :dark="dark_theme"
        ></graphs-card-component>
      </v-col>
      <v-col cols="12" md="6">
        <graphs-card-component
          title="Comissões por Produto"
          subtitle="Donut Chart em frequência relativa e absoluta"
          type="donut"
          icon="mdi-cash-multiple"
          color="rgb(0, 110, 153)"
          height="590"
          graph_width="580"
          :loading="loading_donut_chart_commission_products"
          :options="donut_commission_product"
          :series="series_donut_commission_product"
          :total="total_donut_chart_commission_products"
          no_data_text="Nenhuma comissão foi gerada"
          no_data_image="donut-chart.png"
          no_data_alert_color="teal"
          :dark="dark_theme"
        ></graphs-card-component>
      </v-col>
    </v-row>
    <v-row class="align-center my-5">
      <v-col cols="12">
        <graphs-card-component
          title="Comissões por usuário"
          subtitle="Column Chart em frequência relativa e absoluta"
          type="bar"
          icon="mdi-account-group"
          color="rgb(255, 205, 70)"
          height="720"
          graph_width="1200"
          graph_height="590"
          :loading="loading_column_chart_commission_users"
          :options="column_chart_commission_users"
          :series="series_column_chart_commission_users"
          :total="total_donut_chart_commission_products"
          no_data_text="Nenhuma comissão foi gerada"
          no_data_image="money-column-chart.png"
          no_data_alert_size="600px"
          no_data_alert_color="rgb(255, 205, 70)"
          :dark="dark_theme"
        ></graphs-card-component>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import SparkComponent from './Dashboard/SparkComponent.vue';
import InfoCardsComponent from './Dashboard/InfoCardsComponent.vue';
import GraphsCardComponent from './Dashboard/GraphsCardComponent.vue';
export default {
  name: 'DashboardComponent',
  components: {
    SparkComponent,
    InfoCardsComponent,
    GraphsCardComponent,
  },
  data: () => ({
    info_cards_data: {},
    loading_card_done_products: true,
    loading_card_commissions_val: true,
    loading_card_products_registers: true,
    loading_pie_chart_products: true,
    loading_donut_chart_commission_products: true,
    loading_column_chart_commission_users: true,
    total_spark_done_products: 0,
    total_spark_commissions_val: 0,
    total_spark_products_registers: 0,
    total_pie_chart_products: 0,
    total_donut_chart_commission_products: 0,
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
        theme: 'dark',
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
              '<div class="mr-6">' + '<span>' + value + '</span>' + '</div>'
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
        theme: 'dark',
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
            return 'R$ ' + value;
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
        theme: 'dark',
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
              '<span>' +
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
    series_pie_products_percentage: [],
    pie_products_percentage: {
      chart: {
        width: 380,
        type: 'pie',
      },
      colors: [
        'rgba(255,210,10,1)', //yellow
        'rgba(243,103,10,1)', //orange
        'rgba(255,36,36,1)', //red
        'rgba(255,36,131,1)', //pink
        'rgba(153,16,188,1)', //purple
        'rgba(90,16,188,1)', //indigo
        'rgba(45,16,188,1)', //dark blue
        'rgba(13,174,243,1)', //light blue
        'rgba(13,243,220,1)', //cyan
        'rgba(10,222,67,1)', //green
        'rgba(192,220,10,1)', //green-yellow
      ],
      legend: {
        position: 'bottom',
        labels: {
          useSeriesColors: true,
        },
      },
      fill: {
        colors: [
          'rgba(255,210,10,1)', //yellow
          'rgba(243,103,10,1)', //orange
          'rgba(255,36,36,1)', //red
          'rgba(255,36,131,1)', //pink
          'rgba(153,16,188,1)', //purple
          'rgba(90,16,188,1)', //indigo
          'rgba(45,16,188,1)', //dark blue
          'rgba(13,174,243,1)', //light blue
          'rgba(13,243,220,1)', //cyan
          'rgba(10,222,67,1)', //green
          'rgba(192,220,10,1)', //green-yellow
        ],
        type: 'gradient',
        gradient: {
          type: 'horizontal',
          shadeIntensity: 0.4,
          gradientToColors: [
            'rgba(245,26,26,0.9)', //red
            'rgba(245,26,121,0.9)', //pink
            'rgba(143,6,178,0.9)', //purple
            'rgba(80,6,178,0.9)', //indigo
            'rgba(35,6,178,0.9)', //dark blue
            'rgba(3,164,233,0.9)', //light blue
            'rgba(3,233,210,0.9)', //cyan
            'rgba(0,212,57,0.9)', //green
            'rgba(182,210,0,0.9)', //green-yellow
            'rgba(245,200,0,0.9)', //yellow
            'rgba(233,93,0,0.9)', //orange
          ],
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 100],
          colorStops: [],
        },
      },
      labels: [],
      responsive: [
        {
          breakpoint: 800,
          options: {
            chart: {
              width: 400,
            },
            legend: {
              show: false,
            },
          },
        },
      ],
    },
    series_donut_commission_product: [],
    donut_commission_product: {
      chart: {
        width: 380,
        type: 'donut',
      },
      colors: [
        'rgba(255,210,10,1)', //yellow
        'rgba(243,103,10,1)', //orange
        'rgba(255,36,36,1)', //red
        'rgba(255,36,131,1)', //pink
        'rgba(153,16,188,1)', //purple
        'rgba(90,16,188,1)', //indigo
        'rgba(45,16,188,1)', //dark blue
        'rgba(13,174,243,1)', //light blue
        'rgba(13,243,220,1)', //cyan
        'rgba(10,222,67,1)', //green
        'rgba(192,220,10,1)', //green-yellow
      ],
      labels: [],
      legend: {
        position: 'bottom',
        labels: {
          useSeriesColors: true,
        },
      },
      plotOptions: {
        pie: {
          startAngle: -90,
          endAngle: 270,
          donut: {
            labels: {
              show: true,
              name: {
                show: true,
              },
              value: {
                show: true,
                fontFamily: 'Quicksand, sans-serif',
                fontWeight: '900',
                color: 'black',
              },
              total: {
                label: 'Total R$',
                fontFamily: 'Quicksand, sans-serif',
                fontWeight: '900',
                color: 'red',
                show: true,
                formatter: () => {},
              },
            },
          },
        },
      },
      dataLabels: {
        enabled: true,
      },
      fill: {
        colors: [
          'rgba(255,210,10,0.2)', //yellow
          'rgba(243,103,10,0.2)', //orange
          'rgba(255,36,36,0.2)', //red
          'rgba(255,36,131,0.2)', //pink
          'rgba(153,16,188,0.2)', //purple
          'rgba(90,16,188,0.2)', //indigo
          'rgba(45,16,188,0.2)', //dark blue
          'rgba(13,174,243,0.2)', //light blue
          'rgba(13,243,220,0.2)', //cyan
          'rgba(10,222,67,0.2)', //green
          'rgba(192,220,10,0.2)', //green-yellow
        ],
        type: 'gradient',
        gradient: {
          type: 'horizontal',
          shadeIntensity: 1,
          gradientToColors: [
            'rgba(243,103,10,1)', //orange
            'rgba(255,36,36,1)', //red
            'rgba(255,36,131,1)', //pink
            'rgba(153,16,188,1)', //purple
            'rgba(90,16,188,1)', //indigo
            'rgba(45,16,188,1)', //dark blue
            'rgba(13,174,243,1)', //light blue
            'rgba(13,243,220,1)', //cyan
            'rgba(10,222,67,1)', //green
            'rgba(192,220,10,1)', //green-yellow
            'rgba(255,210,10,1)', //yellow
          ],
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 1,
          stops: [30, 100],
          colorStops: [],
        },
      },
      responsive: [
        {
          breakpoint: 480,
          options: {
            chart: {
              width: 200,
            },
            legend: {
              position: 'bottom',
            },
          },
        },
      ],
    },
    series_column_chart_commission_users: [],
    column_chart_commission_users: {
      chart: {
        type: 'bar',
        height: 350,
        stacked: true,
        toolbar: {
          show: true,
        },
        zoom: {
          enabled: false,
        },
      },
      responsive: [
        {
          breakpoint: 520,
          options: {
            legend: {
              position: 'bottom',
              offsetX: -10,
              offsetY: 0,
            },
            chart: {
              width: 300,
            },
          },
        },
        {
          breakpoint: 705,
          options: {
            legend: {
              position: 'bottom',
              offsetX: -10,
              offsetY: 0,
            },
            chart: {
              width: 500,
            },
          },
        },
        {
          breakpoint: 910,
          options: {
            legend: {
              position: 'bottom',
              offsetX: -10,
              offsetY: 0,
            },
            chart: {
              width: 700,
            },
          },
        },
        {
          breakpoint: 1330,
          options: {
            legend: {
              position: 'bottom',
              offsetX: -10,
              offsetY: 0,
            },
            chart: {
              width: 900,
            },
          },
        },
        {
          breakpoint: 1420,
          options: {
            legend: {
              position: 'bottom',
              offsetX: 10,
              offsetY: 7,
            },
          },
          chart: {
            width: 1000,
          },
        },
        {
          breakpoint: 1590,
          options: {
            legend: {
              position: 'bottom',
              offsetX: 10,
              offsetY: 7,
            },
            chart: {
              width: 1000,
            },
          },
        },
        {
          breakpoint: 1690,
          options: {
            legend: {
              position: 'bottom',
              offsetX: 10,
              offsetY: 7,
            },
            chart: {
              width: 1200,
            },
          },
        },
        {
          breakpoint: 1800,
          options: {
            legend: {
              position: 'bottom',
              offsetX: 10,
              offsetY: 7,
            },
            chart: {
              width: 1400,
            },
          },
        },
        {
          breakpoint: 1930,
          options: {
            legend: {
              position: 'bottom',
              offsetX: 10,
              offsetY: 7,
            },
            chart: {
              width: 1550,
            },
          },
        },
      ],
      plotOptions: {
        bar: {
          horizontal: false,
          borderRadius: 6,
        },
      },
      tooltip: {
        enabled: true,
        shared: true,
        intersect: false,
        theme: 'dark',
      },
      yaxis: {
        labels: {
          formatter: function (value) {
            return 'R$ ' + value;
          },
          style: {
            colors: 'black',
            fontSize: '12px',
            fontFamily: 'Quicksand',
            fontWeight: 900,
          },
        },
      },
      xaxis: {
        categories: [],
        labels: {
          show: true,
          formatter: function (value) {
            let initials = value.match(/\b\w/g).join('. ') + '.';
            initials = initials.substr(initials.indexOf(' ') + 1);
            return value.split(' ').shift() + ' ' + initials;
          },
          style: {
            colors: 'black',
            fontSize: '12px',
            fontFamily: 'Quicksand',
            fontWeight: 900,
          },
        },
      },

      colors: [
        'rgb(221, 224, 0)',
        'rgb(0, 133, 143)',
        'rgb(113, 212, 33)',
        'rgb(135, 44, 195)',
      ],
      legend: {
        position: 'bottom',
        offsetY: 30,
        labels: {
          useSeriesColors: true,
        },
      },
      fill: {
        opacity: 1,
      },
    },
  }),
  mounted() {
    let _this = this;
    window.setInterval(() => {
      _this.checkSystemComs();
    }, 10000);
  },
  created() {
    this.loadDashboard();
  },
  computed: {
    loading_cards() {
      return Boolean(
        this.loading_card_done_products ||
          this.loading_card_commissions_val ||
          this.loading_card_products_registers ||
          this.loading_pie_chart_products ||
          this.loading_donut_chart_commission_products ||
          this.loading_column_chart_commission_users
      );
    },
    dark_theme() {
      try {
        return this.$store.state.user.configs.theme == 0;
      } catch (err) {
        return false;
      }
    },
  },
  methods: {
    checkSystemComs() {
      if (this.loading_cards) {
        return false;
      }
      this.$http.post('get_system_com', { code: 0 }).then((response) => {
        if (response.data) {
          this.loadDashboard(true);
        }
      });
    },
    loadDashboard(att = false) {
      this.darkThemeGraphs();
      this.getCards(att);
    },
    loadingCards() {
      this.loading_pie_chart_products =
        this.loading_donut_chart_commission_products =
        this.loading_column_chart_commission_users =
        this.loading_card_done_products =
        this.loading_card_commissions_val =
        this.loading_card_products_registers =
          true;
    },
    getCards(att) {
      if (att) {
        this.loadingCards();
      }
      this.$http.get('get_info_cards').then((response) => {
        this.info_cards_data = response.data;
      });
      this.getSparkCards();
      this.getCharts();
    },
    getCharts() {
      this.$http.get('get_pie_chart_products').then((response) => {
        this.pie_products_percentage.labels = response.data[0];
        this.series_pie_products_percentage = response.data[1];
        this.total_pie_chart_products = response.data[2];
        this.loading_pie_chart_products = false;
      });
      this.$http.get('get_donut_chart_commission_products').then((response) => {
        this.donut_commission_product.labels = response.data[0];
        this.series_donut_commission_product = response.data[1];
        this.total_donut_chart_commission_products = response.data[2];
        this.loading_donut_chart_commission_products = false;
      });
      this.$http.get('get_column_chart_commission_users').then((response) => {
        this.column_chart_commission_users.xaxis.categories = response.data[0];
        this.series_column_chart_commission_users = response.data[1];
        this.loading_column_chart_commission_users = false;
      });
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
    darkThemeGraphs() {
      this.donut_commission_product.plotOptions.pie.donut.labels.value.color =
        this.dark_theme ? 'white' : 'black';
      this.column_chart_commission_users.xaxis.labels.style.colors =
        this.column_chart_commission_users.yaxis.labels.style.colors = this
          .dark_theme
          ? 'white'
          : 'black';
      this.column_chart_commission_users.tooltip.theme = this.dark_theme
        ? 'dark'
        : 'light';
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
  watch: {
    dark_theme: function () {
      this.darkThemeGraphs();
    },
  },
};
</script>
<style>
.total-text {
  font-family: 'Work Sans', sans-serif;
  font-weight: 500;
  text-shadow: 0.5px 0.5px rgba(0, 0, 0, 0.516);
}
</style>
