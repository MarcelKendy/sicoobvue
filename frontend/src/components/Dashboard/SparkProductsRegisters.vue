<template>
  <div>
    <v-card
      :loading="loading"
      :shaped="hover"
      @mouseenter="hover = !hover"
      @mouseleave="hover = !hover"
      :class="dark_theme ? 'info-cards-dark' : 'info-cards'"
      class="gradient-card gradient-orange"
    >
      <template slot="progress">
        <v-progress-linear
          color="#db2e4b"
          height="4"
          indeterminate
        ></v-progress-linear>
      </template>
      <v-card-title class="info-cards-text">
        <v-row class="align-center">
          <v-col cols="12" md="8">
            <span>Produtos Cadastrados</span>
          </v-col>
          <v-col cols="12" md="4">
            <div
              class="chip gradient-white-orange"
              style="max-width: 120px"
              v-if="!loading"
            >
              <div class="chip__content">
                <span class="total-text">{{ total }}</span>
              </div>
            </div>
          </v-col>
        </v-row>
      </v-card-title>
      <v-card-subtitle class="info-cards-text"
        ><span>Spark Quadrimestral</span></v-card-subtitle
      >
      <v-card-text class="text-center">
        <apex-chart
          v-if="!loading"
          type="line"
          height="120"
          :options="options"
          :series="series"
        ></apex-chart>
        <img
          v-else
          width="60"
          class="my-6"
          src="../../assets/images/loading.gif"
        />
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
export default {
  name: 'SparkProductsRegisters',
  props: ['options', 'series', 'loading', 'total', 'dark_theme'],
  data: () => ({
    hover: true,
  }),
  created() {},
  methods: {},
};
</script>
<style scoped>
.total-text {
}
</style>
