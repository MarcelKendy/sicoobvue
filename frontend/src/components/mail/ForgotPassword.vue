<template>
  <div>
      <v-dialog
      v-model="dialog"
      persistent
      max-width="700"
    > 
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
                icon="mdi-alert"
                rounded
                single-line
                sticky
            >
                <strong>Ops, deu Erro!</strong>
                <p>Não foi possível enviar um E-mail para {{email}}.<br> Contate o desenvolvedor. <strong>Ramal: 1506</strong></p>
            </v-banner>
            <v-banner
                v-if="not_exists"
                color="red"
                dark
                elevation="7"
                icon="mdi-alert"
                rounded
                single-line
                sticky
            >
                <strong>Usuário inexistente!</strong>
                <p>Não existe um usuário de E-mail {{email}}.<br> Contate o desenvolvedor. <strong>Ramal: 1506</strong></p>
            </v-banner>
            <form ref="form">
                 <v-text-field
                    style="padding-top:30px"
                    class="px-3"
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
                    label="E-mail"
                    placeholder="Insira o E-mail cadastrado"
                    v-model="email"
                    outlined
                    name="email"
                    color="#40bfff"
                    @click="not_exists = error = false"
                ></v-text-field>
            </form>
           
        </v-card-text>
         
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="red darken-1"
            text
            :loading="loading"
            @click="closeModal"
          >
            Cancelar
          </v-btn>
          <v-btn
            dark
            :loading="loading"
            color="green"
            @click="getPassword"
            type="submit"
            value="Send"
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
    data () {
        return {
            dialog: false,
            error: false,
            loading: false,
            not_exists: false,
            name: '',
            email: '',
            message: '',
            software_name: 'Sicoob Credisg Software'
        }
        
    },
    watch: {
      activate: function () {
        this.dialog = this.activate
      }
    },
    methods: {
        sendEmail() {
            try {
                emailjs.sendForm('service_gacoq7w', 'template_x6ehuag', 'nome='+this.name+'&email='+this.email, 'FRJFFdpcsV5eietF6',{
                    to_name: this.name,
                    to_email:this.email,
                    message: this.message,
                    from_name: this.software_name
                },
                ).then(this.success())
            } catch(error) {
                console.log({error})
                this.error = true
                this.loading = false
            }
        },
        success () {
          this.error = this.not_exists = this.loading = false  
          this.$emit('success')    
        },
        closeModal () {
          this.error = this.not_exists = this.loading = false 
          this.name = this.email = this.message = '' 
          this.$emit('closeModalMail')    
        },
        getPassword () {
            this.loading = true
            this.$http.post('get_user_password', {email: this.email}).then((response)=>{
                if (response.data.length) {
                    this.message = 'Olá, a sua senha é: "' + response.data[0].password + '".'
                    this.sendEmail()
                } else {
                    this.not_exists = true
                    this.loading = false
                }
            })
        }
    }
}
</script>

<style>
.forgot-title{
    color: #40bfff;
    font-weight: bolder;
    font-family: 'Quicksand', sans-serif;
  }
</style>