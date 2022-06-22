<template>
  <div>
    <v-card
      v-if="classes.length > 0"
      :loading="loading"
      :shaped="hover"
      @mouseenter="hover = !hover"
      @mouseleave="hover = !hover"
      :class="classes"
    >
      <template slot="progress">
        <v-progress-linear
          :color="loading_color"
          height="4"
          indeterminate
        ></v-progress-linear>
      </template>
      <v-card-title class="spark-cards-text">
        <v-row class="align-center">
          <v-col cols="12" :md="total.length > 9 ? '6' : '8'">
            <span>{{(title.length > 19 && total.length > 9) ? title.split(' ')[0] : title}}</span>
            <span v-if="(title.length > 19 && total.length > 9)"><br>{{title.split(' ')[1]}}</span>
          </v-col>
          <v-col cols="12" :md="total.length > 9 ? '6' : '4'">
            <div
              :class="'chip gradient-white-' + gradient"
              :style="'max-width: ' + total.length > 9 ? '160px;' : '140px;'"
              v-if="!loading"
            >
              <div class="chip__content">
                <span class="total-text">{{ total }}</span>
              </div>
            </div>
          </v-col>
        </v-row>
      </v-card-title>
      <v-card-subtitle class="spark-cards-text"
        ><span>{{subtitle}}</span></v-card-subtitle
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
  name: 'SparkComponent',
  props: ['options', 'series', 'loading', 'total', 'dark_theme', 'gradient', 'loading_color', 'title', 'subtitle'],
  data: () => ({
    hover: true,
  }),
  created() {},
  methods: {},
  computed: {
    classes() {
      let classes = this.dark_theme
        ? 'spark-cards-dark gradient-card gradient-'
        : 'spark-cards gradient-card gradient-';
      classes = classes.concat(this.gradient)
       
      return classes;
    },
  },
};
</script>

