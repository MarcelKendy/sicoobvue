<template>
  <div>
    <v-card class="hover-card" elevation="7" outlined shaped :dark="dark_theme">
      <v-card-title>
        <span class="bold title-card">Importar Dados</span>
      </v-card-title>
      <v-card-subtitle>
        <span :class="dark_theme ? 'bold subtitle-card-dark' : 'subtitle-card'"
          >Importa arquivos para o funcionamento do sistema</span
        >
      </v-card-subtitle>
      <v-card-text>
        <v-hover>
          <template v-slot:default="{ hover }">
            <v-card
              :class="dark_theme ? 'sub-card-dark' : 'sub-card'"
              :shaped="hover"
              :elevation="hover ? 9 : 3"
            >
              <v-card-title
                ><span
                  class="sub-card-title"
                  :class="dark_theme ? 'blue--text' : 'white--text'"
                  >Upload de Associados</span
                >
                <v-spacer></v-spacer>
                <v-tooltip left>
                  <template v-slot:activator="{ attrs, on }">
                    <v-btn icon dark v-bind="attrs" v-on="on"
                      ><v-icon color="yellow">mdi-information</v-icon></v-btn
                    >
                  </template>
                  <span>Informações sobre a importação</span>
                </v-tooltip>
              </v-card-title>
              <v-card-text>
                <v-row align="center">
                  <v-col cols="6">
                    <v-file-input
                      dark
                      :loading="loading_import_associates"
                      v-model="files.associates"
                      accept=".xlsx"
                      label="Insira a planilha (.xlsx)"
                      color="green"
                      placeholder="Selecione uma planilha com todos os associados"
                      prepend-icon="mdi-microsoft-excel"
                      show-size
                      truncate-length="40"
                      @change="changeFileAssociates"
                    ></v-file-input>
                  </v-col>
                </v-row>
              </v-card-text>
            </v-card>
          </template>
        </v-hover>
      </v-card-text>
    </v-card>
    <v-snackbar
      v-model="snackbar"
      timeout="2500"
      elevation="24"
      rounded="pill"
      :color="snackbar_type == 1 ? 'success' : 'error'"
    >
      <v-icon class="pr-3" dark>{{
        snackbar_type == 1 ? 'mdi-alert-circle-check' : 'mdi-robot-dead'
      }}</v-icon>
      <strong style="padding-left: 35px" class="white--text">{{
        snackbar_message
      }}</strong>
    </v-snackbar>
  </div>
</template>

<script>
import readXlsxFile from 'read-excel-file';
export default {
  name: 'UploadComponent',

  data: () => ({
    files: {
      associates: null,
    },
    loading_import_associates: false,
    snackbar: false,
    snackbar_type: 0,
    snackbar_message: '',
  }),
  methods: {
    changeFileAssociates(file) {
      if (!file) {
        return false;
      }
      this.loading_import_associates = true;
      let obj_excel_data = [];
      readXlsxFile(file).then((data) => {
        data.shift();
        data.map(function (row) {
           obj_excel_data.push({
             account: row[0],
             associate: row[1],
             cpf_cnpj: row[2],
             phone: row[3],
             account_type: row[4],
             category: row[5],
             group: row[6]
           });
         });
        this.$http
          .post('/upload_associates', obj_excel_data)
          .then((response) => {
            if (response.data == 1) {
              this.snackbar_type = 1;
              this.snackbar_message = 'Associados importados com sucesso';
            } else {
              console.log(response.data)
              this.snackbar_type = 0;
              this.snackbar_message = 'Houve um erro na importação';
            }
            this.loading_import_associates = false;
            this.snackbar = true;
          });
      });
    },
  },
  computed: {
    dark_theme() {
      return this.$store.state.user.configs.theme == 0;
    },
  },
};
</script>
<style scoped>
.sub-card {
  transition: 0.3s;
  background-color: rgba(51, 59, 68, 0.63);
}
.sub-card-dark {
  transition: 0.3s;
  background-color: rgba(82, 95, 105, 0.15);
}
.sub-card-title {
  font-weight: bold;
  font-size: 17px;
}
</style>
