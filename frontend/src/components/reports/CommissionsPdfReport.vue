<template>
  <div>
    <div class="container">
      <div class="font-quicksand">
        <h2 style="color: green; display: inline">Relatório de Comissões</h2>
        <img
          style="margin-right: 0px"
          width="30px"
          src="./../../assets/icons/sicoobicon.png"
        />
        <br />
      </div>
      <div
        style="margin-top: 30px"
        v-for="(page, index_page) in items_table"
        :key="index_page"
      >
        <table id="table-data" border="2" bordercolor="#32a85c" cellpadding="5">
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
              {{ item.seller_commission ? 'R$ ' + item.seller_commission : '' }}
            </td>
            <td>
              {{
                item.operator_commission ? 'R$ ' + item.operator_commission : ''
              }}
            </td>
          </tr>
        </table>
        <img
          src="@/assets/images/logos/logosicoobcredisg.png"
          width="60px"
          style="position: absolute; left: 15px; margin-top: 10px"
          alt="Sicoob Credisg"
        />
        <div class="html2pdf__page-break" />
      </div>
    </div>
    <div class="font-quicksand" style="margin-left: 30px; margin-y: 30px">
      <span style="text-align: center">--Fim dos Registros--</span>
      <br />
      <small class="bold">Filtros Aplicados: </small>
      <small>
        [ {{ info[0] }}, {{ info[1] }}, {{ info[2] }}, {{ info[3] }}
      </small>
      <br />
      <small v-if="mutable_info.length == 0">{{ info[4] }} ]</small>
      <small
        v-else
        v-for="(associate_account, index) in mutable_info"
        :key="index"
      >
        <span>{{ mutable_info[index] }}</span>

        <br />
      </small>
      <br />
      <small class="bold">Requisitado em: </small
      ><small>{{ new Date().toLocaleString() }} | </small
      ><small class="bold">Usuário: </small
      ><small>{{ $store.state.user.full_name }}</small>
      <div class="bold">
        <span>Total de páginas: {{ items_table.length }}</span>
        <br />
        <span>Registros por página (máx): 10</span>
        <br />
        <span>Total de Registros: {{ info[5] }}</span>
        <br />
        <span
          >{{ $store.state.software.name }} -
          {{ $store.state.software.version }}</span
        >
      </div>
      <br />
    </div>
  </div>
</template>

<script>
export default {
  name: 'CommissionsPdfReport',
  props: ['items_table', 'info'],
  components: {},
  data() {
    return {
      mutable_info: [],
    };
  },
  methods: {
    popArray(array, indexes) {
      indexes.forEach((index) => {
        array.splice(index, 1);
      });
      return array;
    },
    arrangeMutableInfo(array, qtt = 4) {
      if (array.length <= qtt) {
        return [array.join(', ')];
      }
      let array_return = []
      for (let i = 0; i < array.length; i += qtt) {
        let chunk = array.slice(i, i + qtt);
        array_return.push(chunk.join())
      }
      return array_return;
    },
  },
  computed: {
    info_associates() {
      return this.info[4];
    },
  },
  watch: {
    info_associates: function () {
      this.mutable_info = [];
      if (this.info[4].length > 150) {
        this.mutable_info = this.arrangeMutableInfo(this.info[4].split(','));
      }
    },
  },
};
</script>

<style lang="scss" scoped>
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