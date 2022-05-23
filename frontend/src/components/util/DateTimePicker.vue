<template>
  <div>
    <v-menu
      v-model="dialog"
      :close-on-content-click="false"
      :nudge-width="200"
      max-width="290"
      offset-y
      :color="color"
    >
      <template v-slot:activator="{ on }">
        <v-text-field
          v-model="value_mutable"
          :label="label"
          v-bind="$attrs"
          v-on="on"
          :disabled="disabled"
          :rules="rules"
          readonly
          :prepend-icon="prependIcon"
          :color="color"
        ></v-text-field>
      </template>
      <template v-slot:default="dialog">
        <v-card>
          <v-tabs v-model="tabs" fixed-tabs>
            <v-tabs-slider color="black"></v-tabs-slider>
            <v-tab href="#pick-date" class="primary--text">
              <v-icon :color="tabs == 'pick-date' ? color : 'gray'"
                >mdi-calendar</v-icon
              >
            </v-tab>

            <v-tab href="#pick-time" class="primary--text">
              <v-icon :color="tabs == 'pick-time' ? color : 'gray'"
                >mdi-clock</v-icon
              >
            </v-tab>
          </v-tabs>
          <v-tabs-items v-model="tabs">
            <v-tab-item value="pick-date">
              <v-date-picker
                locale="pt-BR"
                :color="color"
                v-model="datePicker"
              ></v-date-picker>
            </v-tab-item>
            <v-tab-item value="pick-time">
              <v-time-picker
                :color="color"
                format="ampm"
                v-model="timePicker"
                scrollable
              ></v-time-picker>
            </v-tab-item>
          </v-tabs-items>
          <v-card-text> </v-card-text>
          <v-card-actions class="justify-end">
            <v-btn text :color="color" @click="clear(true)" v-if="clearable"
              >Limpar</v-btn
            >
            <v-btn text :color="color" @click="dialog.value = false">OK</v-btn>
          </v-card-actions>
        </v-card>
      </template>
    </v-menu>
  </div>
</template>

<script>
import VInput from "vuetify/lib/components/VInput/VInput.js";
export default {
  extends: VInput,
  data() {
    return {
      dialog: false,
      datePicker: "",
      timePicker: "",
      tabs: "pick-date",
      value_mutable: this.value,
    };
  },
  props: {
    value: {
      required: false,
      type: [String],
    },
    rules: {
      required: false,
      default: function () {
        return [(v) => !!v || "Essa informação é obrigatória"];
      },
    },
    required: {
      required: false,
      type: [Boolean],
    },
    label: {
      required: false,
      type: [String],
    },
    clearable: {
      required: false,
      type: [Boolean],
    },
    preset: {
      required: false,
      type: [Boolean],
    },
    color: {
      required: false,
      type: [String],
      default: "blue",
    },
    prependIcon: {
      required: false,
      type: [String],
      default: "mdi-calendar-clock",
    },
    updateComponent: {
      required: false,
      type: [Boolean],
    },
    disabled: {
      required: false,
      type: [Boolean],
    },
  },
  watch: {
    datePicker: function () {
      if (this.timePicker) {
        this.$emit("input", this.datePicker + " " + this.timePicker);
        this.value_mutable = this.datePicker + " " + this.timePicker;
      } else {
        this.$set(this, "tabs", "pick-time");
      }
    },
    timePicker: function () {
      if (this.datePicker) {
        this.$emit("input", this.datePicker + " " + this.timePicker);
        this.value_mutable = this.datePicker + " " + this.timePicker;
      } else {
        this.$set(this, "tabs", "pick-date");
      }
    },
    updateComponent: function () {
      if (this.updateComponent) {
        this.value_mutable = this.value;
        if (this.value_mutable) {
          this.updateValue();
        }
      } else {
        this.clear();
      }
    },
  },
  methods: {
    updateValue() {
      let date = this.value_mutable.slice(0, 10);
      let time = this.value_mutable.slice(11, 17);
      this.datePicker = date;
      this.timePicker = time;
      this.$set(this, "datePicker", date);
      this.$set(this, "timePicker", time);
    },
    clear(close = false) {
      this.value_mutable = "";
      this.$emit("resetValidation");
      this.datePicker = "";
      this.timePicker = "";
      this.$set(this, "datePicker", null);
      this.$set(this, "timePicker", null);
      this.$emit("input", null);
      if (close) {
        this.dialog = false;
      }
    },
  },
  mounted() {
    if (this.preset) {
      const time = new Date().toLocaleTimeString("en-US", {
        hour12: false,
        hour: "numeric",
        minute: "numeric",
      });
      const date = new Date().toISOString().substr(0, 10);
      this.$set(this, "datePicker", date);
      this.$set(this, "timePicker", time);
      this.$emit("input", date + " " + time);
    }
  },
};
</script>