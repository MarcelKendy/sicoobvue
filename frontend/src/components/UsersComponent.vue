<template>
  <div>
    <v-card
      class="font-quicksand hover-card"
      shaped
      elevation="7"
      :loading="loading"
      outlined
    >
      <v-card-title>
        <span class="bold">Usuários do Sistema</span>
      </v-card-title>
      <v-card-subtitle>
        <span class="bold">Controle de usuários</span>
      </v-card-subtitle>
      <v-card-text>
        <v-list three-line>
          <template v-for="(item) in items">
            <v-list-item :key="item.id">
              <v-list-item-avatar>
                <v-img v-if="item.photo" :src="item.photo"></v-img>
                <v-icon v-else>mdi-account-circle</v-icon>
              </v-list-item-avatar>

              <v-list-item-content>
               <v-row>
                 <v-col cols="12" sm="3">
                   <span class="bold">{{item.full_name}}</span>
                 </v-col>
                  <v-col cols="12" sm="3">
                   <span class="bold">{{item.role}}</span>
                 </v-col>
               </v-row>
              </v-list-item-content>
            </v-list-item>
          </template>
        </v-list>
      </v-card-text>
      <v-card-actions>
        <span class="bold page-items-text mx-3">Itens por página:</span>
        <v-col cols="1">
          <v-form ref="form" v-model="valid" lazy-validation>
            <vuetify-number
              class="page-items-textfield"
              v-model="page_total_items"
              v-bind:rules="requiredRule"
              v-bind:color="color"
              v-bind:options="options"
            />
          </v-form>
        </v-col>

        <v-spacer></v-spacer>
        <v-pagination
          v-model="page"
          style="font-weight: bold"
          circle
          :length="total_pages"
          :total-visible="7"
        ></v-pagination>
      </v-card-actions>
    </v-card>
  </div>
</template>

<script>
export default {
  name: 'UsersComponent',

  data: () => ({
    total_items: [],
    items: [],
    total_pages: 1,
    page_total_items: 5,
    page: 1,
    loading: false,
    valid: true,
    color: 'orange',
    requiredRule: [(v) => v > 0 || 'x > 0'],
    options: {
      locale: 'pt-BR',
      prefix: '',
      suffix: '',
      length: 2,
      precision: 0,
    },
  }),
  created() {
    this.getUsers();
  },
  methods: {
    pagination(reload_total_pages = true) {
      if (reload_total_pages) {
        this.total_pages = Math.ceil(
          this.total_items.length / this.page_total_items
        );
      }
      this.page_total_items = parseInt(this.page_total_items);
      let begin = (this.page - 1) * this.page_total_items;
      let end = begin + this.page_total_items;
      this.items = this.total_items.slice(begin, end);
    },
    getUsers() {
      this.loading = true;
      this.$http.post('get_users').then((response) => {
        console.log(response.data)
        this.total_items = response.data;
        this.pagination();
        this.loading = false;
      });
    },
  },
};
</script>
