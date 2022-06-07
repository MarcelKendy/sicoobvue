<template>
  <vue-html2pdf
    :show-layout="false"
    :float-layout="true"
    :enable-download="true"
    :preview-modal="true"
    :manual-pagination="false"
    :paginate-elements-by-height="1400"
    :filename="name"
    :pdf-quality="2"
    pdf-format="a4"
    pdf-orientation="landscape"
    pdf-content-width="1600px"
    @progress="onProgress($event)"
    ref="html2Pdf"
  >
    <section slot="pdf-content">
      <section class="pdf-item">
        <div class="container">
          <div class="font-quicksand">
            <h2 style="color: green">Relatório de Comissões</h2>
            <small class="bold">{{ info[1] }}</small>
            <small>
              [ {{ info[2] }}, {{ info[3] }}, {{ info[4] }},
              {{ info[5] }} ]</small
            >
            <br />
            <small>{{ info[6] }}</small>
          </div>
          <div
            style="margin-top: 30px"
            v-for="(page, index_page) in items_table"
            :key="index_page"
          >
            <table id="table-data">
              <tr>
                <th>Produto</th>
                <th>Valor</th>
                <th>Status</th>
                <th>Indicador</th>
                <th>Vendedor</th>
                <th>Operador</th>
                <th>Com. Coop.</th>
                <th>Com. Indicador</th>
                <th>Com. Vendedor</th>
                <th>Com. Operador</th>
              </tr>
              <tr v-for="item in page" :key="item.id">
                <td>{{ item.product }}</td>
                <td>{{ item.value ? 'R$ ' + item.value : '' }}</td>
                <td>{{ item.status }}</td>
                <td>{{ item.indicator_id ? item.indicator.full_name : '' }}</td>
                <td>{{ item.seller_id ? item.seller.full_name : '' }}</td>
                <td>{{ item.operator_id ? item.operator.full_name : '' }}</td>
                <td>
                  {{
                    item.commission_percentage
                      ? item.commission_percentage + '%'
                      : ''
                  }}
                </td>
                <td>
                  {{
                    item.indicator_commission
                      ? 'R$ ' + item.indicator_commission
                      : ''
                  }}
                </td>
                <td>
                  {{
                    item.seller_commission ? 'R$ ' + item.seller_commission : ''
                  }}
                </td>
                <td>
                  {{
                    item.operator_commission
                      ? 'R$ ' + item.operator_commission
                      : ''
                  }}
                </td>
              </tr>
            </table>
            <div class="html2pdf__page-break" />
          </div>
        </div>
        <div
          class="font-quicksand bold"
          style="margin-left: 30px; margin-y: 30px"
        >
          <span>{{ info[7] }}</span>
          <br />
          <span>Total de páginas: {{ items_table.length }}</span>
          <br />
          <span>Registros por página (máx): 10</span>
          <br />
          <span>Total de Registros: {{ data.length }}</span>
        </div>
      </section>
    </section>
  </vue-html2pdf>
</template>

<script>
import VueHtml2pdf from 'vue-html2pdf';
export default {
  name: 'PdfGeneratorComponent',
  props: ['generate', 'type', 'data', 'name', 'info'],
  components: { VueHtml2pdf },
  data: () => ({
    items_table: [],
  }),
  methods: {
    generatePDF() {
      if (this.type == 'table') {
        this.items_table = [];
        if (this.data.length > 0) {
          this.items_table = this.chunkArray(this.data, 10);
          console.log(this.items_table);
          this.$refs.html2Pdf.generatePdf();
        }
      }
    },
    onProgress(event) {
      this.$emit('progress', event);
    },
    chunkArray(full_array, chunk_size) {
      let index = 0;
      let array_length = full_array.length;
      let sub_array = [];
      let temp_array = [];
      for (index = 0; index < array_length; index += chunk_size) {
        sub_array = full_array.slice(index, index + chunk_size);
        temp_array.push(sub_array);
      }
      return temp_array;
    },
  },
  watch: {
    generate: function () {
      if (this.generate) {
        this.generatePDF();
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.title {
}
.container {
  margin-left: 10px;
  text-align: center;
}
#table-data {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 93%;
}
#table-data td,
#table-data th {
  border: 1px solid #ddd;
  padding: 2px;
  width: 20px !important;
  font-size: 18px;
  font-weight: bold;
}
#table-data td {
  font-size: 15px;
}
#table-data tr:nth-child(even) {
  background-color: #f2f2f2;
}

#table-data th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: center;
  background-color: #00b070;
  color: white;
}
</style>