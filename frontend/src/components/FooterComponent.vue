<template>
  <v-footer dark padless>
    <v-card class="flex" flat tile>
      <v-img
        src="../assets/images/footer-banner.png"
        :gradient="dark_theme ? 'to bottom left, rgba(43,12,127,.6), rgba(0,180,85,.7)' : 'to bottom left, rgba(173,12,227,.6), rgba(0,260,145,.4)'"
        dark
        class="pt-5 text-center"
        max-height="82"
      >
        <div
          v-for="item in items"
          :key="item.destination"
          style="width: 100px; display: inline"
        >
          <v-tooltip id="tooltip" top>
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                class="mx-10"
                text
                target="_blank"
                :href="item.destination"
                v-bind="attrs"
                v-on="on"
              >
                <img
                  :src="require('../assets/images/' + item.img)"
                  alt="CPro"
                  contain
                  :height="item.height"
                  :width="item.width"
                />
              </v-btn>
            </template>
            <span>{{ item.title }}</span>
          </v-tooltip>
          <span v-if="item.icon">{{ item.title }}</span>
        </div>
        <div style="padding-left: 30px; display: inline">
          <v-menu
            transition="slide-y-reverse-transition"
            top
            offset-y
            offset-x
            v-model="link_modal"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-badge
                color="primary"
                :icon="!link_modal ? 'mdi-chevron-up' : 'mdi-chevron-down'"
                overlap
              >
                <v-btn
                  small
                  class="purple"
                  color="primary"
                  dark
                  v-bind="attrs"
                  v-on="on"
                >
                  Links
                </v-btn>
              </v-badge>
            </template>

            <v-list style="">
              <v-list-item
                class="effect"
                v-for="(item, i) in items_links"
                :key="i"
                link
                target="_blank"
                :href="item.destination"
              >
                <v-list-item-icon>
                  <v-icon v-if="item.icon" v-text="item.icon"></v-icon>
                  <span v-else class="material-symbols-outlined">
                    {{ item.icon_google }}
                  </span>
                </v-list-item-icon>
                <v-list-item-content>
                  <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list>
          </v-menu>
        </div>
      </v-img>
      <v-card-text class="py-2 white--text text-center">
        {{ new Date().getFullYear() }} — <strong>Sicoob Credisg TI</strong> —
        São Gotardo/MG
      </v-card-text>
    </v-card>
  </v-footer>
</template>

<script>
export default {
  name: 'FooterComponent',

  data: () => ({
    link_modal: false,
    items: [
      {
        img: 'logosicoobcredisg.png',
        width: '68',
        height: '44',
        title: 'Interativa',
        destination: 'http://172.22.84.243/interativa/',
      },
      {
        img: 'cpro.png',
        width: '88',
        height: '35',
        title: 'CPro',
        destination: 'http://172.22.84.243/CPro/',
      },
      {
        img: 'ccontrol.png',
        width: '88',
        height: '35',
        title: 'CControl',
        destination: 'http://172.22.84.243/CControl/',
      },
      {
        img: 'sicoobicon.png',
        width: '32',
        height: '30',
        title: 'Sicoob',
        destination: 'https://www.sicoob.com.br/web/sicoobcredisg',
      },
    ],

    items_links: [
      {
        icon_google: 'gavel',
        title: 'Ilicitude',
        destination: 'https://www.sicoob.com.br/sdmcr/home/informacao.asp',
      },
      {
        icon: 'mdi-lock-clock',
        title: 'Painel de Senha',
        destination: 'http://172.22.84.33/agil/login.php',
      },
      {
        icon: 'mdi-microsoft-office',
        title: 'Office',
        destination: 'http://portal.office.com',
      },
      {
        icon: 'mdi-newspaper-variant-multiple',
        title: 'Citrix',
        destination:
          'https://portal.sisbr.coop.br/Citrix/XenApp/clientDetection/downloadNative.aspx',
      },
      {
        icon: 'mdi-account-group',
        title: 'Gestão de Pessoas',
        destination:
          'https://portal.sisbr.coop.br/cas/login?service=https%3A%2F%2Fportal.sisbr.coop.br%2Fcas%2Fidp%2Fprofile%2FSAML2%2FPOST%2FSSO%2FCallback.%2B%3FentityId%3Dhttps%253A%252F%252Fwww.successfactors.com%252Fsicoob%26SAMLRequest%3DPD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz48c2FtbDJwOkF1dGhuUmVxdWVzdCB4bWxuczpzYW1sMnA9InVybjpvYXNpczpuYW1lczp0YzpTQU1MOjIuMDpwcm90b2NvbCIgQXNzZXJ0aW9uQ29uc3VtZXJTZXJ2aWNlVVJMPSJodHRwczovL3BlcmZvcm1hbmNlbWFuYWdlcjQuc3VjY2Vzc2ZhY3RvcnMuY29tL3NhbWwyL1NBTUxBc3NlcnRpb25Db25zdW1lcj9jb21wYW55PXNpY29vYiIgRGVzdGluYXRpb249Imh0dHBzOi8vcGVyZm9ybWFuY2VtYW5hZ2VyNC5zdWNjZXNzZmFjdG9ycy5jb20vc2FtbDIvU0FNTEFzc2VydGlvbkNvbnN1bWVyP2NvbXBhbnk9c2ljb29iIiBGb3JjZUF1dGhuPSJmYWxzZSIgSXNzdWVJbnN0YW50PSIyMDIyLTA1LTA0VDEzOjU4OjM3LjgzN1oiIFByb3RvY29sQmluZGluZz0idXJuOm9hc2lzOm5hbWVzOnRjOlNBTUw6Mi4wOmJpbmRpbmdzOkhUVFAtUE9TVCIgVmVyc2lvbj0iMi4wIj48c2FtbDI6SXNzdWVyIHhtbG5zOnNhbWwyPSJ1cm46b2FzaXM6bmFtZXM6dGM6U0FNTDoyLjA6YXNzZXJ0aW9uIj5odHRwczovL3d3dy5zdWNjZXNzZmFjdG9ycy5jb20vc2ljb29iPC9zYW1sMjpJc3N1ZXI%252BPGRzOlNpZ25hdHVyZSB4bWxuczpkcz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC8wOS94bWxkc2lnIyI%252BCjxkczpTaWduZWRJbmZvPgo8ZHM6Q2Fub25pY2FsaXphdGlvbk1ldGhvZCBBbGdvcml0aG09Imh0dHA6Ly93d3cudzMub3JnLzIwMDEvMTAveG1sLWV4Yy1jMTRuIyIvPgo8ZHM6U2lnbmF0dXJlTWV0aG9kIEFsZ29yaXRobT0iaHR0cDovL3d3dy53My5vcmcvMjAwMS8wNC94bWxkc2lnLW1vcmUjcnNhLXNoYTI1NiIvPgo8ZHM6UmVmZXJlbmNlIFVSST0iIj4KPGRzOlRyYW5zZm9ybXM%252BCjxkczpUcmFuc2Zvcm0gQWxnb3JpdGhtPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwLzA5L3htbGRzaWcjZW52ZWxvcGVkLXNpZ25hdHVyZSIvPgo8ZHM6VHJhbnNmb3JtIEFsZ29yaXRobT0iaHR0cDovL3d3dy53My5vcmcvMjAwMS8xMC94bWwtZXhjLWMxNG4jIi8%252BCjwvZHM6VHJhbnNmb3Jtcz4KPGRzOkRpZ2VzdE1ldGhvZCBBbGdvcml0aG09Imh0dHA6Ly93d3cudzMub3JnLzIwMDEvMDQveG1sZW5jI3NoYTI1NiIvPgo8ZHM6RGlnZXN0VmFsdWU%252BNm5sMkFmRkhQaEhOMkk4V1lEbFd3NzZMcFd6Yms4RzYzNy9yV2xyUFFaND08L2RzOkRpZ2VzdFZhbHVlPgo8L2RzOlJlZmVyZW5jZT4KPC9kczpTaWduZWRJbmZvPgo8ZHM6U2lnbmF0dXJlVmFsdWU%252BCnI5LzliMVpUY2RTSWc3Z2lxaWZzdlBMQnB1M21maVFoSHE5ZTJ1UjNac3ErMFI5anRmMEt2MW03UlphWHNDdVlFUGp1SERDYkZqaWwKWlVrOUMrd0JKODNpQVdvVDNzNEY4R3VrZEV6aC80cnlxOVNUQkQvT2ZkWVoxRUtpeEZLZlRla1FoeE5Cemhkc21wbnRwNXRtV3NiSQpNaVBnUCtCd0RPdVg3VWF3S3VST2plVnhyY3crMHl4aUdHSUpsRHY0dU1tZEhPMzhFdHpXb2orcEE3dWwxWXJmcWRJd1l3YVRCYjV0CmZORzZLcUhWa2E5bVRoYXpaVzU5andQcU50WFZrdHg2SUJtYXIzVzJhazltRzFYYldsLzhSeTdRWGUvZFh3NkVMUGFPS3VsTU5BZ1QKbnRnUkFFSFN5bTArZ1dkaHIrd2RYVFhrVlFOeGlkT1hkcDZWYUE9PQo8L2RzOlNpZ25hdHVyZVZhbHVlPgo8ZHM6S2V5SW5mbz48ZHM6WDUwOURhdGE%252BPGRzOlg1MDlDZXJ0aWZpY2F0ZT5NSUlEQlRDQ0FlMmdBd0lCQWdJVU9iN1BsOHZNNGFkTWIySWdDL2N3ZGJDR3J1NHdEUVlKS29aSWh2Y05BUUVMQlFBd0ZERVNNQkFHCkExVUVBd3dKYkc5allXeG9iM04wTUI0WERURTNNRGd4TVRFNU1qRTFObG9YRFRNM01EZ3hNVEU1TWpFMU5sb3dGREVTTUJBR0ExVUUKQXd3SmJHOWpZV3hvYjNOME1JSUJJakFOQmdrcWhraUc5dzBCQVFFRkFBT0NBUThBTUlJQkNnS0NBUUVBc2tabGpRUG8vckg0OHZDdQpkR25iUVc0VmpWb3ZkLy9sRE90blV1eE9nT0xzUnFmZE4xZUxNWjRXSDJmOW12WkFtL2Nsai85bFlvSUJHdUNGczdEREZwaUFQS0oyClpQY2JnWTVYaHRBM0hWSzFVRjdsb2pjTnV3L01rWVEyTm5LeUhxaG5QMzZTQVJCaGkvQ0RUTXErT1UzMDI1aTk1azBOczZPNFV6TXMKY2N5bnFxLzZDaE9IYkNFQ0NFZklHeTVZb1FwOUNFZnFJdWJFRGVzdE14eFhRVVNSMXpQbGE0R0pPZmZIVE9tM2hRVzFHcmt0eFB3cwpFNDVnYm5MelEzTytNY1Y5aHgxeTlVVDdDL05Qb1dKQU04LzdMUENuNWJDZmFVYmtla3JYWVZ5cm83c2k5TnJ6Y0d0SXMwbjlhVVZZCjJnWlNvZHpLVlpNZG1JNWlpRmRta3dJREFRQUJvMDh3VFRBZEJnTlZIUTRFRmdRVWV5U1hFWVpWNitqN1MwNDI1WjdxK3Nwc0FPOHcKTEFZRFZSMFJCQ1V3STRJSmJHOWpZV3hvYjNOMGhoWnNiMk5oYkdodmMzUXZhV1J3TDIxbGRHRmtZWFJoTUEwR0NTcUdTSWIzRFFFQgpDd1VBQTRJQkFRQ1pmNVZtVm9UNHFpSHJoMW1kR1JmSjVrTU9Wd3hteHpqaGRLZUlxN0FEZXVja2Y1Zm9SS0lkWHlnZjdqbUlmKytUCnlFeTlyM3lUT3p3QmpvV1R0dUJJTkFlR0ExLy9lSEx5V2M5OEQ4eGJGQ1RrNHhzSUhidnQwQytSSzFXL014LzA4ZUFoZnl3MnJEWjgKL0RhVFNwUkZ3aFZXN2cwSGl3RFQvVGtBK3AwbjBMRmQwZjc3OWVPRTF3c1NDbFBCTzZhVFJlU0xBV2N4RklWMHpKRTN5UlR2QkI0dwp2RkYvMm5UWTF5TnYySVJtZHg2UElFTUFKN3ZaWkV3cUtOZnNsWXJibHJyeXFINGRUYXo3Z2IyQStCaUgvQ0szSXp4OVpCaUs2eldSCnRJVzZPY2tLQTRwQ1NJODNBZ3U0blNHT29rRlkxdkJaYkRMOTZ1ZWlvQ3U5UWNJeDwvZHM6WDUwOUNlcnRpZmljYXRlPjwvZHM6WDUwOURhdGE%252BPC9kczpLZXlJbmZvPjwvZHM6U2lnbmF0dXJlPjxzYW1sMnA6TmFtZUlEUG9saWN5IEFsbG93Q3JlYXRlPSJ0cnVlIi8%252BPC9zYW1sMnA6QXV0aG5SZXF1ZXN0Pg%253D%253D%26RelayState',
      },
      {
        icon: 'mdi-phone-plus',
        title: 'Portal de Serviços',
        destination: 'http://172.16.0.67/',
      },
      {
        icon: 'mdi-domain',
        title: 'Crediminas',
        destination: 'https://portal.crediminas.com.br/PortalAcessos/',
      },
      {
        icon: 'mdi-store-search',
        title: 'Sisbr Analítico',
        destination:
          'https://portal.sisbr.coop.br/cas/login?service=https%3a%2f%2fsisbranalitico.sisbr.coop.br%2fsisbranalitico%2fbi%2f%3fperspective%3ddashboard%26pathRef%3d.public_folders%252F%2525C3%252581rea%252BP%2525C3%2525BAblica%252B-%252BConsumidor%252F%2525C3%252581rea%252BP%2525C3%2525BAblica%252Bda%252BCentral%252B1003%252B-%252BConsumidor%252F%2525C3%252581rea%252BP%2525C3%2525BAblica%252Bda%252BSingular%252B3267%252B-%252BConsumidor%252FAN%2525C3%252581LISE%252BGERENCIAL%252FBASE%252BDE%252BDADOS%252FANALISE%252BGERENTES%26action%3dview%26mode%3ddashboard%26subView%3dmodel000001735d7f9ba0_00000001',
      },
    ],
  }),
  computed: {
     dark_theme() {
      try {
        return this.$store.state.user.configs.theme == 0;
      } catch (err) {
        return false;
      }
    },
  }
};
</script>
<style scoped>
.effect {
  transition: 0.2s;
}
.effect:hover {
  background-color: aquamarine;
  box-shadow: 0px 2px 10px 1px rgb(39, 58, 59), 0px 0px 0px 0px;
}
</style>