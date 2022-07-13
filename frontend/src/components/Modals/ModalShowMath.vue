<template>
  <div>
    <v-dialog v-model="dialog" :dark="dark_theme" persistent max-width="850">
      <v-card :loading="loading" height="508">
        <template slot="progress">
          <v-progress-linear
            color="teal"
            height="10"
            indeterminate
          ></v-progress-linear>
        </template>
        <v-card-title class="title-modal">
          <strong>Cálculo das Comissões</strong>
          <v-spacer></v-spacer>
          <img width="30" src="../../assets/images/logos/sicoobicon.png" />
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text class="mt-4">
          <v-slide-x-reverse-transition>
            <v-alert
              v-if="first_alert_animation"
              icon="mdi-calculator"
              color="rgb(3, 89, 81)"
              border="left"
              elevation="7"
              dark
              prominent
            >
              <strong>Produto: </strong> {{ item.product }}
              <v-spacer></v-spacer>
              <strong>Valor Comissionado: </strong>R$ {{ item.value }}
              <v-spacer></v-spacer>
              <strong>Porcentagem de comissão: </strong
              >{{ item.commission_percentage }}%
              <v-spacer></v-spacer>
              <strong
                >{{ item.commission_percentage }}% do Valor Comissionado: </strong
              >R$ {{ item.percentage_value }}
              <v-spacer></v-spacer>
              <strong
                >Contabiliza-se 80% de {{ item.commission_percentage }}% do
                Valor Comissionado: </strong
              >R$ {{ item.percentage_value_effective }}
              <v-spacer></v-spacer>
              <strong>Descontam-se os impostos (3,5%) Valor Efetivo de: </strong
              >R$ {{ item.percentage_value_effective_taxes }}
              <v-spacer></v-spacer>
            </v-alert>
          </v-slide-x-reverse-transition>
          <v-slide-x-reverse-transition>
            <v-alert
              v-if="second_alert_animation"
              icon="mdi-calculator"
              color="rgb(0, 133, 104)"
              border="left"
              elevation="7"
              dark
              prominent
            >
            <template slot="prepend">
                <v-img
                  class="mr-3"
                  max-width="72px"
                  :src="require('@/assets/images/commission.png')"
                ></v-img>
              </template>
              <strong
                >Dado o valor efetivo de R$
                {{ item.percentage_value_effective_taxes }}:</strong
              >
              <v-spacer></v-spacer>
              <strong>Comissão da Cooperativa (96%): </strong>R$
              {{ item.credisg_commission }}
              <v-spacer></v-spacer>
              <strong>Comissão dos Funcionários (4%): </strong>R$
              {{
                (
                  item.percentage_value_effective_taxes -
                  item.credisg_commission
                ).toFixed(2)
              }}
              <v-spacer></v-spacer>
              <strong
                >Comissão pela Indicação
                <span style="font-weight: 400">{{ item.indicator }} </span>
                (20%): </strong
              >R$ {{ item.indicator_commission }}
              <v-spacer></v-spacer>
              <strong
                >Comissão pela Venda
                <span style="font-weight: 400">{{ item.seller }} </span>
                (60%): </strong
              >R$ {{ item.seller_commission }}
              <v-spacer></v-spacer>
              <strong
                >Comissão pela Operação
                <span style="font-weight: 400">{{ item.operator }} </span>
                (20%): </strong
              >R$ {{ item.operator_commission }}
              <v-spacer></v-spacer>
            </v-alert>
          </v-slide-x-reverse-transition>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions v-if="!loading">
          <v-spacer></v-spacer>
          <v-btn color="teal" @click="emitClose"
            ><v-icon color="white"> mdi-thumb-up </v-icon>
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  props: ['open', 'data'],
  data() {
    return {
      dialog: false,
      loading: false,
      first_alert_animation: false,
      second_alert_animation: false,
      item: {},
    };
  },
  watch: {
    open: function () {
      this.loading = false;
      this.dialog = this.open;
      setTimeout(() => {
        this.first_alert_animation = true;
      }, 200);
      setTimeout(() => {
        this.second_alert_animation = true;
      }, 600);
    },
    data: function () {
      Object.assign(this.item, this.data);
    },
  },
  methods: {
    emitClose() {
      this.$emit('closeShowMathModal');
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

<style scoped>
.title-modal {
  font-family: 'Quicksand', sans-serif;
  color: rgb(0, 124, 161);
}
</style>