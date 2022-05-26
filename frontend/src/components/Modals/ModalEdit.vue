<template>
  <div>
    <v-dialog v-model="dialog" persistent max-width="700">
      <v-card :loading="loading">
        <template slot="progress">
          <v-progress-linear
            :color="color"
            height="10"
            indeterminate
          ></v-progress-linear>
        </template>
        <v-card-title class="title-modal" v-if="!loading">
          <strong>Editar Tarefa</strong>
          <v-spacer></v-spacer>
          <img width="30" src="../../assets/images/sicoobicon.png" />
        </v-card-title>
        <v-card-title class="title-modal" v-else>
          <strong>Salvando</strong>
          <v-spacer></v-spacer>
          <img width="50" src="../../assets/images/loading.gif" />
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text class="mt-7" v-if="loading">
          <v-row align="center" justify="center">
            <v-col cols="12">
              <v-alert
                :color="color"
                border="left"
                elevation="3"
                dark
                icon="mdi-content-save"
              >
                <span>Espera só um pouquinho, carregando...</span>
              </v-alert>
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-text class="mt-4" v-else>
          <v-form ref="form" v-model="valid" lazy-validation>
            <v-row align="center">
              <v-col cols="12">
                <v-text-field
                  class="px-3"
                  label="Nome"
                  placeholder="Insira o novo nome"
                  v-model="item.title"
                  :rules="requiredRule"
                  prepend-icon="mdi-account-tie-voice"
                  :color="color"
                  outlined
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-textarea
                  class="px-3"
                  label="Descrição"
                  placeholder="Insira a nova descrição"
                  v-model="item.subtitle"
                  :color="color"
                  prepend-icon="mdi-account-tie"
                  :rules="requiredRule"
                  auto-grow
                  outlined
                ></v-textarea>
              </v-col>
            </v-row>
          </v-form>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions v-if="!loading">
          <v-spacer></v-spacer>
          <v-btn
            color="red darken-1"
            dark
            text
            @click="$emit('closeModalEdit')"
          >
            Cancelar
          </v-btn>
          <v-btn :color="color" text @click="editTask" :disabled="!valid">
            Salvar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  props: ['task'],
  data() {
    return {
      dialog: true,
      valid: true,
      loading: false,
      color: 'orange',
      item: {},
      requiredRule: [(v) => !!v || 'Essa informação é obrigatória'],
    };
  },
  created() {
    Object.assign(this.item, this.task);
  },
  methods: {
    editTask() {
      if (this.$refs.form.validate()) {
        this.loading = true;
        this.$http
          .put(`edit_task/${this.item.id}`, this.item)
          .then((response) => {
            this.$emit('taskEdited', response.data);
            this.$emit('closeModalEdit');
            this.loading = false;
          });
      }
    },
  },
};
</script>

<style>
.title-modal {
  font-family: 'Quicksand', sans-serif;
  color: orange;
}
.item-select-badge {
  font-weight: bold;
  padding-left: 5px;
}
</style>