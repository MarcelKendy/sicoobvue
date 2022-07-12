<template>
  <div>
    <v-card
      class="hover-card"
      shaped
      elevation="7"
      :loading="loading"
      outlined
      :dark="dark_theme"
    >
      <template v-slot:progress>
        <v-progress-linear
          height="6"
          indeterminate
          color="green lighten-1"
        ></v-progress-linear>
      </template>
      <v-card-title class="bold title-card">
        <span>Contas abertas na Cooperativa</span>
        <v-img
          class="mx-2"
          style="display: inline-block"
          src="@/assets/icons/sicoobicon.png"
          max-width="20"
        ></v-img>
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          :disabled="loading"
          append-icon="mdi-magnify"
          label="Pesquisar"
          :dark="dark_theme"
          single-line
          color="rgba(18,210,175)"
        ></v-text-field>
      </v-card-title>
      <v-card-subtitle>
        <span :class="dark_theme ? 'bold subtitle-card-dark' : 'subtitle-card'"
          >Listagem completa de associados e suas contas ativas/inativas</span
        >
      </v-card-subtitle>
      <v-card-text>
        <img
          v-if="loading"
          width="70"
          class="loading-gif my-10"
          src="../assets/images/loading.gif"
        />
        <div
          v-if="no_data_animation"
          class="mt-16 animate__animated animate__bounceInUp"
        >
          <center style="padding-bottom: 60px">
            <!-- <v-img
              width="50"
              :src="require('@/assets/icons/bots/bot1/bot-question.png')"
            ></v-img> -->
            <v-icon size="50" color="rgba(18,210,195)">mdi-emoticon-sad</v-icon>
            <div
              class="mt-3"
              style="
                color: rgba(18, 210, 195);
                font-size: 24px;
                font-weight: bold;
                font-family: 'Quicksand', sans-serif;
              "
            >
              Nenhum associado(a) encontrado(a)
            </div>
          </center>
        </div>
        <v-list three-line v-for="(item, index) in items" :key="index">
          <v-list-item
            :key="item.cpf_cnpj"
            :class="dark_theme ? 'list-item-dark' : 'list-item'"
          >
            <v-list-item-avatar class="mt-6" size="38">
              <v-img :src="require('@/assets/icons/associate.png')"
                ><v-btn
                  color="success"
                  width="38"
                  height="38"
                  icon
                  to=""
                ></v-btn
              ></v-img>
            </v-list-item-avatar>
            <v-list-item-content class="bold">
              <span>{{ item.associate }}</span>
              <v-list-item-subtitle>
                <span>{{ item.cpf_cnpj }}</span>
              </v-list-item-subtitle>
            </v-list-item-content>

            <v-chip
              :dark="dark_theme"
              @click.stop.prevent="
                copyInfo('account_' + parseInt(item.cpf_cnpj), 'Conta')
              "
            >
              <v-avatar left>
                <v-img src="@/assets/icons/account.png"></v-img>
              </v-avatar>
              <span class="font-quicksand bold">{{ item.account }}</span>
            </v-chip>
            <v-list-item-content></v-list-item-content>
            <v-list-item-content>
              <v-chip
                :dark="dark_theme"
                class="chip-phone"
                @click.stop.prevent="
                  copyInfo('phone_' + parseInt(item.cpf_cnpj), 'Telefone')
                "
              >
                <v-avatar left>
                  <v-img src="@/assets/icons/phone_corporation.png"></v-img>
                </v-avatar>
                <span class="font-quicksand bold">{{ item.phone }}</span>
              </v-chip>
            </v-list-item-content>
            <v-list-item-content
              ><input
                type="hidden"
                :id="'account_' + parseInt(item.cpf_cnpj)"
                :value="item.account"
              />
              <input
                type="hidden"
                :id="'phone_' + parseInt(item.cpf_cnpj)"
                :value="item.phone"
              />
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-card-text>
      <v-card-actions v-if="!loading">
        <span
          :style="dark_theme ? 'color: white' : ''"
          class="bold page-items-text mx-3"
          >Itens por página:</span
        >
        <div style="max-width: 37px">
          <v-form ref="form_page_items" v-model="valid_page" lazy-validation>
            <vuetify-number
              class="page-items-textfield"
              v-model="page_total_items"
              v-bind:rules="pageItemsRule"
              v-bind:options="options"
              v-bind:backgroundColor="dark_theme ? 'rgb(30, 30, 31)' : ''"
            />
          </v-form>
        </div>

        <v-spacer></v-spacer>
        <v-pagination
          v-model="page"
          style="font-weight: bold"
          circle
          :length="total_pages"
          :total-visible="5"
        ></v-pagination>
      </v-card-actions>
    </v-card>
    <v-snackbar
      v-model="snackbar_copy"
      timeout="2500"
      elevation="24"
      rounded="pill"
      color="success"
    >
      <v-icon class="pr-3" dark>mdi-check-circle</v-icon>
      <strong style="padding-left: 35px" class="white--text">{{
        this.snackbar_copy_message
      }}</strong>
    </v-snackbar>
  </div>
</template>

<script>
export default {
  name: 'AssociatesComponent',

  data: () => ({
    loading: false,
    items: [],
    total_items: [],
    mutable_total_items: [],
    snackbar_copy: false,
    snackbar_copy_message: '',
    no_data_animation: false,
    valid_page: true,
    total_pages: 1,
    page_total_items: 10,
    page: 1,
    pageItemsRule: [(v) => v > 0 || 'x > 0'],
    options: {
      locale: 'pt-BR',
      prefix: '',
      suffix: '',
      length: 2,
      precision: 0,
    },
    search: '',
  }),
  created() {
    this.getAssociates();
  },
  methods: {
    getAssociates() {
      this.loading = true;
      this.$http
        .post('get_associates', {
          select: ['associate', 'cpf_cnpj', 'phone', 'account'],
        })
        .then((response) => {
          this.total_items = response.data;
          this.mutable_total_items = response.data;
          this.pagination();
          this.loading = false;
        });
    },
    copyInfo(info, title) {
      let element = document.querySelector('#' + info);
      element.setAttribute('type', 'text');
      element.select();

      try {
        let successful = document.execCommand('copy');
        this.snackbar_copy_message = successful
          ? '"' + title + '"' + ' copiado com sucesso!'
          : 'Não foi possível copiar ' + title;
        this.snackbar_copy = true;
      } catch (err) {
        alert(
          'Algum erro ocorreu. Certifique-se de usar o Google Chrome e contate o desenvolvedor.'
        );
      }

      /* unselect the range */
      element.setAttribute('type', 'hidden');
      window.getSelection().removeAllRanges();
    },
    pagination(reload_total_pages = true, page = this.page) {
      if (reload_total_pages) {
        this.total_pages = Math.ceil(
          this.mutable_total_items.length / this.page_total_items
        );
      }
      this.page = page;
      this.page_total_items = parseInt(this.page_total_items);
      let begin = (page - 1) * this.page_total_items;
      let end = begin + this.page_total_items;
      this.items = this.mutable_total_items.slice(begin, end);
    },
    filterData() {
      this.mutable_total_items = this.total_items.filter((item) => {
        return this.search
          .toLowerCase()
          .split(' ')
          .every(
            (search_char) =>
              item.associate.toLowerCase().includes(search_char) ||
              item.cpf_cnpj.toLowerCase().includes(search_char) ||
              item.account.toLowerCase().includes(search_char) ||
              item.phone.toLowerCase().includes(search_char)
          );
      });
      this.pagination(true, 1);
    },
  },
  watch: {
    search: function () {
      if (this.search.length > 0) {
        this.filterData();
      } else {
        this.items = [];
        this.mutable_total_items = this.total_items;
        this.pagination(true, 1);
      }
    },
    no_data: function () {
      this.no_data_animation = this.no_data;
    },
    page: function () {
      this.pagination(false);
    },
    page_total_items: function () {
      if (this.$refs.form_page_items.validate()) {
        this.pagination(true, 1);
      } else {
        this.page_total_items = 10;
        this.pagination(true, 1);
      }
    },
  },
  computed: {
    no_data() {
      return this.items.length == 0;
    },
    dark_theme() {
      return this.$store.state.user.configs.theme == 0;
    },
  },
};
</script>
<style scoped>
.chip-phone {
  max-width: 160px;
}
</style>