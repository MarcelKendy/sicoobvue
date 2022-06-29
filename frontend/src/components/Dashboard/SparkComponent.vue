<template>
  <div>
    <v-scale-transition>
      <v-card
        v-show="classes.length > 0 && show_animation"
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
              <span>{{
                title.length > 19 && total.length > 9
                  ? title.split(' ')[0]
                  : title
              }}</span>
              <span v-if="title.length > 19 && total.length > 9"
                ><br />{{ title.split(' ')[1] }}</span
              >
            </v-col>
            <v-col cols="12" :md="total.length > 9 ? '6' : '4'">
              <div
                :class="'chip gradient-white-' + gradient"
                :style="total.length > 9 ? 'width: 130px;' : 'width: 110px;'"
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
          ><span>{{ subtitle }}</span></v-card-subtitle
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
    </v-scale-transition>
  </div>
</template>

<script>
export default {
  name: 'SparkComponent',
  props: [
    'options',
    'series',
    'loading',
    'total',
    'dark_theme',
    'gradient',
    'loading_color',
    'title',
    'subtitle',
  ],
  data: () => ({
    hover: true,
    show_animation: false,
  }),
  created() {
    let _this = this;
    setTimeout(function () {
      _this.show_animation = true;
    }, 200);
  },
  methods: {},
  computed: {
    classes() {
      let classes = this.dark_theme
        ? 'spark-cards-dark gradient-card gradient-'
        : 'spark-cards gradient-card gradient-';
      classes = classes.concat(this.gradient);

      return classes;
    },
  },
};
</script>

<style scoped>
.spark-cards {
  border-radius: 10px;

  transition: 0.3s;
}
.spark-cards:hover {
  box-shadow: rgba(0, 0, 0, 0.25) 0px 19px 38px,
    rgba(0, 0, 0, 0.22) 6px 6px 6px 6px !important;
  transition: 0.3s;
}
.spark-cards-dark {
  border-radius: 15px;

  transition: 0.3s;
}
.spark-cards-dark:hover {
  box-shadow: rgb(0, 0, 0) 0px 19px 38px, rgb(0, 0, 0) 6px 6px 6px 6px !important;
  transition: 0.3s;
}
.spark-cards-text {
  font-family: 'Quicksand', sans-serif;
  color: white !important;
  font-weight: bold !important;
}
</style>