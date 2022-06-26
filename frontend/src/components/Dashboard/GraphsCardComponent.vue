<template>
  <div>
    <v-expand-transition>
      <div v-if="show_animation">
        <v-card
          :width="width"
          :height="height"
          :dark="dark"
          :loading="loading"
          :class="dark ? 'hover-card-dark' : 'hover-card'"
        >
          <template slot="progress">
            <v-progress-linear
              :color="color"
              height="6"
              indeterminate
            ></v-progress-linear>
          </template>
          <v-card-title
            ><strong :style="'color: ' + color">{{ title }}</strong
            ><v-spacer></v-spacer>
            <v-hover v-slot:default="{ hover }">
              <v-chip
                class="ma-2"
                :color="color"
                :outlined="!hover"
                :dark="hover"
              >
                <v-icon left> {{ icon }} </v-icon>
                <strong>Total: </strong
                ><strong class="mx-2">{{ total }}</strong>
              </v-chip>
            </v-hover>
          </v-card-title>
          <v-card-subtitle
            ><strong>{{ subtitle }}</strong></v-card-subtitle
          >
          <v-card-text
            :class="loading ? 'text-center' : 'd-flex justify-center'"
          >
            <img
              v-if="loading || reset"
              width="70"
              class="my-10 mt-16"
              src="@/assets/images/loading.gif"
            />
            <apex-chart
              v-else-if="total > 0 || total.length > 0"
              :type="type"
              :width="graph_width"
              :options="mutable_options"
              :series="series"
            ></apex-chart>
            <div v-else class="mt-14">
              <v-alert
                :width="no_data_alert_size"
                :color="no_data_alert_color"
                border="left"
                elevation="10"
                outlined
                dark
                prominent
              >
                <template slot="prepend">
                  
                </template>
                <h3>{{ no_data_text }}</h3>

                <v-img
                  class="ma-10"
                  :width="no_data_image_size"
                  :src="require('@/assets/images/' + no_data_image)"
                ></v-img>
                <p class="mt-2">{{ new Date().toLocaleString() }}</p>
              </v-alert>
            </div>
          </v-card-text>
        </v-card>
      </div>
    </v-expand-transition>
  </div>
</template>

<script>
export default {
  props: {
    type: {},
    color: {
      required: false,
      type: [String],
      default: 'blue',
    },
    width: {
      required: false,
      type: [String],
    },
    height: {},
    graph_width: {},
    series: {},
    options: {},
    title: {},
    icon: {},
    subtitle: {},
    total: {},
    dark: {},
    delay: {},
    no_data_text: {
      required: false,
      type: [String],
      default: 'Sem dados referentes',
    },
    no_data_image: {
      required: false,
      type: [String],
      default: 'empty-box.png',
    },
    no_data_image_size: {
      required: false,
      type: [String],
      default: '220px',
    },
    no_data_alert_size: {
      required: false,
      type: [String],
      default: '420px',
    },
    no_data_alert_color: {
      required: false,
      type: [String],
      default: 'blue',
    },
    loading: {},
  },
  name: 'GraphsCardComponent',
  data: () => ({
    show_animation: false,
    mutable_options: {},
    reset: false,
  }),
  mounted() {},
  created() {
    let _this = this;
    if (this.assignMutableOptions()) {
      setTimeout(function () {
        _this.show_animation = true;
      }, 500);
    }
  },
  methods: {
    assignMutableOptions() {
      this.mutable_options = this.options;
      if (this.type == 'donut') {
        if (Object.getOwnPropertyDescriptor(this.options, 'plotOptions')) {
          this.mutable_options.plotOptions.pie.donut.labels.total.formatter =
            () => {
              return this.total;
            };
          return true;
        } else {
          return false;
        }
      }
      return true;
    },
  },
  watch: {
    options: function () {
      this.assignMutableOptions();
    },
    dark: function () {
      this.reset = true;
      let _this = this;
      setTimeout(function () {
        _this.reset = false;
      }, 1);
    },
  },
};
</script>

<style scoped>
.hover-card-dark {
  box-shadow: rgba(97, 97, 97, 0.12) 0px 2px 4px 0px,
    rgbrgba(88, 88, 88, 0.32) x 2px 6px 0px !important;

  transition: 0.3s;
}
.hover-card-dark:hover {
  box-shadow: rgb(71, 71, 71) 0px 12px 17px, rgb(62, 62, 62) 0px 15px 12px !important;
  transition: 0.3s;
}
</style>