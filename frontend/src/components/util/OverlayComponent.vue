<template>
  <div>
    <v-overlay
      :absolute="absolute"
      :value="model_mutable"
      :opacity="dark_theme ? '0.4' : '0.5'"
      :color="dark_theme ? '#64418a' : 'black'"
    >
      <v-slide-y-transition>
        <v-card
          :width="width"
          class="font-quicksand"
          v-show="model_mutable_delayed"
        >
          <v-card-title>
            <span> {{ title }} </span>
            <v-spacer></v-spacer>
            <img width="30" src="../../assets/images/logos/sicoobicon.png" />
          </v-card-title>
          <v-card-subtitle>
            <span> {{ sub_title }} </span>
          </v-card-subtitle>
          <v-divider></v-divider>
          <v-card-text>
            <v-alert
              :icon="icon"
              :color="color"
              border="left"
              elevation="7"
              dark
              prominent
            >
              <template slot="prepend" v-if="prepend_image">
                <v-img
                  width="64px"
                  :src="require('@/assets/' + prepend_image)"
                ></v-img>
              </template>
              <h3>{{ text }}</h3>
              <p class="mt-2">{{ description }}</p>
              <div v-if="image">
                <v-img
                  :height="image_height"
                  :width="image_width"
                  :src="require('@/assets/' + image)"
                ></v-img>
              </div>
              <v-divider v-if="footer"></v-divider>
              <span v-if="footer" class="font-weight-bold mt-3 font-italic">
                {{ footer }}
              </span>
            </v-alert>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn :color="color" @click="emitClose"
              ><v-icon> mdi-thumb-up </v-icon>
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-slide-y-transition>
    </v-overlay>
  </div>
</template>

<script>
export default {
  name: 'OverlayComponent',
  props: {
    color: {
      required: false,
      type: [String],
      default: 'blue',
    },
    model: {
      required: true,
      type: [Boolean],
      default: false,
    },
    absolute: {
      required: false,
      type: [Boolean],
      default: true,
    },
    title: {
      required: true,
      type: [String],
    },
    sub_title: {
      required: false,
      type: [String],
    },
    text: {
      required: true,
      type: [String],
    },
    description: {
      required: false,
      type: [String],
    },
    footer: {
      required: false,
      type: [String],
    },
    icon: {
      required: false,
      type: [String],
      default: 'mdi-alert',
    },
    prepend_image: {
      required: false,
      type: [String],
    },
    image: {
      required: false,
      type: [String],
    },
    image_width: {
      required: false,
      type: [String],
      default: '400',
    },
    image_height: {
      required: false,
      type: [String],
      default: '',
    },
    width: {
      required: false,
      type: [String],
      default: '500',
    },
  },
  data: () => ({
    model_mutable: false,
    model_mutable_delayed: false,
  }),
  watch: {
    model: function () {
      this.model_mutable = this.model;
      setTimeout(this.activateTransition, 100);
    },
  },
  methods: {
    emitClose() {
      this.$emit('closeOverlay');
    },
    activateTransition() {
      this.model_mutable_delayed = this.model_mutable;
    },
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
};
</script>

<style>
</style>