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
       <commissions-pdf-report v-if="report == 'commissions'" :items_table="items_table" :info="info_table"></commissions-pdf-report>
      </section>
    </section>
  </vue-html2pdf>
</template>

<script>
import VueHtml2pdf from 'vue-html2pdf';
import CommissionsPdfReport from './../Reports/CommissionsPdfReport.vue';
export default {
  name: 'PdfGeneratorComponent',
  props: ['generate', 'type', 'data', 'name', 'info', 'report'],
  components: { VueHtml2pdf, CommissionsPdfReport },
  data: () => ({
    items_table: [],
    info_table: []
  }),
  methods: {
    generatePDF() {
      if (this.type == 'table') {
        this.items_table = [];
        if (this.data.length > 0) {
          this.info_table = this.info
          this.info_table.push(this.data.length)
          this.items_table = this.chunkArray(this.data, 10);
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
  background-color: #dfeff0;
}

#table-data th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: center;
  background-color: #00b070;
  color: white;
}
</style>