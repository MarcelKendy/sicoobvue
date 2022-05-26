<template>
  <div>
    <v-dialog v-model="dialog" persistent max-width="700">
      <v-card>
        <v-card-title class="forgot-title">
          <h4>Receber minha senha por E-mail</h4>
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text class="mt-4">
          <v-banner
            v-if="error"
            color="red"
            dark
            elevation="7"
            icon="mdi-robot-dead"
            rounded
            single-line
            sticky
          >
            <strong>Ops, deu Erro!</strong>
            <p>
              Não foi possível enviar um E-mail para {{ email }}.<br />
              Contate o desenvolvedor. <strong>Ramal: 1506</strong>
            </p>
          </v-banner>
          <v-banner
            v-if="not_exists"
            color="red"
            dark
            elevation="7"
            icon="mdi-robot-confused"
            rounded
            single-line
            sticky
          >
            <strong>Usuário inexistente!</strong>
            <p>
              Não existe um usuário de E-mail {{ email }}.<br />
              Contate o desenvolvedor. <strong>Ramal: 1506</strong>
            </p>
          </v-banner>
          <v-form ref="form" v-model="valid" lazy-validation>
            <v-text-field
              style="padding-top: 30px"
              class="px-3"
              :rules="requiredRule"
              label="Nome"
              placeholder="Insira o nome cadastrado"
              v-model="name"
              outlined
              name="nome"
              color="#40bfff"
              @click="not_exists = error = false"
            ></v-text-field>
            <v-text-field
              class="px-3"
              :rules="emailRule"
              label="E-mail"
              placeholder="Insira o E-mail cadastrado"
              v-model="email"
              outlined
              name="email"
              color="#40bfff"
              @click="not_exists = error = false"
            ></v-text-field>
          </v-form>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="red darken-1"
            text
            :disabled="loading"
            @click="closeModal"
          >
            Cancelar
          </v-btn>
          <v-btn
            class="white--text"
            :disabled="!valid"
            :loading="loading"
            color="green"
            @click="getPassword"
          >
            Enviar
            <v-icon right>mdi-email-fast</v-icon>
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import emailjs from 'emailjs-com';
export default {
  props: ['activate'],
  data() {
    return {
      dialog: false,
      valid: true,
      error: false,
      loading: false,
      not_exists: false,
      name: '',
      email: '',
      message: '',
      software_name: 'Sicoob Credisg Software',
      emailRule: [
        (v) => !!v || 'Digite o seu E-mail',
        (v) => /.+@.+\..+/.test(v) || 'E-mail inválido',
      ],
      requiredRule: [(v) => !!v || 'Essa informação é obrigatória'],
    };
  },
  watch: {
    activate: function () {
      this.dialog = this.activate;
    },
  },
  methods: {
    sendEmail() {
      try {
        emailjs
          .send(
            'service_gacoq7w',
            'template_x6ehuag',
            {
              to_name: this.name,
              to_email: this.email,
              message: this.message,
              from_name: this.software_name,
            },
            'FRJFFdpcsV5eietF6'
          )
          .then(this.success());
      } catch (error) {
        console.log({ error });
        this.error = true;
        this.loading = false;
      }
    },
    success() {
      this.error = this.not_exists = this.loading = false;
      this.name = this.email = this.message = '';
      this.$refs.form.reset();
      this.$emit('success');
    },
    closeModal() {
      this.error = this.not_exists = this.loading = false;
      this.name = this.email = this.message = '';
      this.$refs.form.reset();
      this.$emit('closeModalMail');
    },
    getPassword() {
      if (this.$refs.form.validate()) {
        this.error = this.not_exists = false;
        this.loading = true;
        this.$http
          .post('get_user_password', { email: this.email })
          .then((response) => {
            if (response.data.length) {
              this.message =
                'Olá, a sua senha é: "' + response.data[0].password + '".';
              this.sendEmail();
            } else {
              this.not_exists = true;
              this.loading = false;
            }
          });
      }
    },
  },
};
</script>

<style>
.forgot-title {
  color: #40bfff;
  font-weight: bolder;
  font-family: 'Quicksand', sans-serif;
}
</style>