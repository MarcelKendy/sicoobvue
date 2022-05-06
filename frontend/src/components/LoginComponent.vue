<template>
<div>
        <v-card max-width="600px" min-width="300px" class="hover-card center gamer-border">
                <v-tabs v-model="tab"  show-arrows :background-color="color_default" icons-and-text dark grow>
                    <v-tabs-slider color="rgba(18,200,285)"></v-tabs-slider>
                    <v-tab :disabled="loading_btn" v-for="i in tabs" :key="i.name">
                        <v-icon large>{{ i.icon }}</v-icon>
                        <div class="caption py-1">{{ i.name }}</div>
                    </v-tab>
                    <v-tab-item>
                        <v-card class="px-4">
                            <v-card-text>
                                <v-form ref="loginForm" v-model="validLogin" lazy-validation>
                                    <v-row>
                                        <v-col cols="12">
                                            <v-text-field v-model="formLogin.email" :rules="emailRule" name="login_email" :color="color_default" label="E-mail" required></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field v-model="formLogin.password" @keyup.enter="validate('login')" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" :color="color_default" :rules="passwordRule" :type="show1 ? 'text' : 'password'" name="login_password" label="Senha" hint="No mínimo 5 caracteres" counter @click:append="show1 = !show1"></v-text-field>
                                        </v-col>
                                        <v-col class="d-flex" cols="12"  sm="6" xsm="12">
                                          <span v-if="!loading_btn" class="forgot-text" @click="modal_mail = true">Esqueci minha senha</span>
                                        </v-col>
                                        <v-spacer></v-spacer>
                                        <v-col class="d-flex" cols="12" sm="4" xsm="12" align-end>
                                            <v-btn x-large block :disabled="!validLogin" :loading="loading_btn" class="white--text btn btn-3" :color="color_default" @click="validate('login')"> Login </v-btn>
                                        </v-col>
                                    </v-row>
                                </v-form>
                            </v-card-text>
                        </v-card>
                    </v-tab-item>
                    <v-tab-item>
                        <v-card class="px-4">
                            <v-card-text>
                                <v-form ref="registerForm" v-model="validRegister" lazy-validation>
                                    <v-row>
                                        <v-col cols="12" sm="6" md="6">
                                            <v-text-field v-model="formRegister.firstName" :rules="requiredRule" label="Nome" :color="color_default" name="register_first_name" maxlength="20" required></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="6">
                                            <v-text-field v-model="formRegister.lastName" :rules="requiredRule" label="Sobrenome" :color="color_default" name="register_last_name" maxlength="20" required></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="6">
                                            <v-text-field v-model="formRegister.email" :rules="emailRule" label="E-mail" :color="color_default" name="register_email" required></v-text-field>
                                        </v-col>
                                         <v-col cols="12" sm="6" md="6">
                                            <v-text-field-simplemask
                                              label= "CPF"
                                              v-model="formRegister.cpf"
                                              v-bind:properties="{
                                               color: color_default,
                                               rules: cpfRule,
                                               name: 'register_cpf', 
                                               required: true
                                              }"
                                              v-bind:options="{
                                                inputMask: '###.###.###-##',
                                                outputMask: '###########',
                                                empty: null,
                                                applyAfter: false,
                                                numeric: true,
                                                lowerCase: false,
                                              }"
                                            />
                                            
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field v-model="formRegister.password" :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'" :rules="passwordRule" :type="show2 ? 'text' : 'password'" name="register_password" label="Senha" hint="No mínimo 5 caracteres" counter :color="color_default" @click:append="show2 = !show2"></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field block @keyup.enter="validate('register')" v-model="formRegister.verify" :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'" :rules="[rules.verifyPasswordRule, matchPasswords]" :type="show2 ? 'text' : 'password'" name="verify_password" label="Confirme a senha" :color="color_default" counter @click:append="show2 = !show2"></v-text-field>
                                        </v-col>
                                        <v-spacer></v-spacer>
                                        <v-col class="d-flex ml-auto" cols="12" sm="4" xsm="12">
                                            <v-btn x-large block :disabled="!validRegister" :loading="loading_btn" class="white--text btn btn-3" :color="color_default" @click="validate('register')">Salvar</v-btn>
                                        </v-col>
                                    </v-row>
                                </v-form>
                            </v-card-text>
                        </v-card>
                    </v-tab-item>
                </v-tabs>
                <v-snackbar
                  v-model="invalid_credentials"
                  timeout="2500"
                  elevation="24"
                  rounded="pill"
                  color="red"
                >
                  <v-icon class="pr-3" dark >mdi-alert</v-icon>
                  <strong style="padding-left: 35px" class="white--text">Dados de Login inválidos</strong>
                </v-snackbar>
                <v-snackbar
                  v-model="register_succeeded"
                  timeout="3200"
                  elevation="24"
                  rounded="pill"
                  color="green"
                >
                  <v-icon class="pr-3" dark >mdi-check</v-icon>
                  <strong style="padding-left: 25px" class="white--text">Você foi cadastrado com sucesso, É só logar! </strong><v-icon class="pr-3" dark >mdi-emoticon-cool</v-icon>
                </v-snackbar>
                <v-snackbar
                  v-model="success_mail"
                  timeout="2200"
                  elevation="24"
                  rounded="pill"
                  color="green"
                >
                  <v-icon class="pr-3" dark >mdi-email-check</v-icon>
                  <strong style="padding-left: 25px" class="white--text">Senha enviada com sucesso, confere lá! </strong><v-icon class="pr-3" dark >mdi-emoticon-cool</v-icon>
                </v-snackbar>
        </v-card>
        <forgot-password :activate="modal_mail" @success="emailSuccess" @closeModalMail="closeModalMail" />
</div>        
</template>

<script>

import ForgotPassword from './mail/ForgotPassword.vue';
  export default {
  components: { ForgotPassword },
    name: 'LoginComponent',
    computed: {
      matchPasswords() {
        return this.formRegister.password === this.formRegister.verify || "As senhas não coincidem";
      },
       logged_user() {
          return this.$store.state.user    
      },
    },
    methods: {
      validate(form) {
        if (form == 'login') {
          if (this.$refs.loginForm.validate()) {
            this.validLogin = false
            this.loading_btn = true
            this.$http.post('get_user', this.formLogin).then((response)=>{
              if (response.data.length) {
                this.$store.dispatch('login', response.data[0]).then(
                  this.$router.push('/')
                )
              } else {
                this.loading_btn = false
                this.invalid_credentials = true
                this.validLogin = true
              }
            })
          }  
        } else {
          if (this.$refs.registerForm.validate()) {
            this.validRegister = false
            this.loading_btn = true
            this.$http.post('add_user', this.formRegister).then(()=>{
              this.loading_btn = false
              this.tab = '1'
              this.register_succeeded = true
              this.formRegister = {firstName: "", lastName: "", email: "", cpf: "", password: "", verify: ""}
              this.$refs.registerForm.reset()
            })
          }  
        }
      },
      reset() {
        this.$refs.form.reset();
      },
      resetValidation() {
        this.$refs.form.resetValidation();
      },
      emailSuccess () {
        this.closeModalMail()
        this.success_mail = true
      },
      closeModalMail () {
        this.modal_mail = false
      }
    },
    data: () => ({
      tab: 0,
      tabs: [
          {name:"Login", icon:"mdi-account"},
          {name:"Cadastro", icon:"mdi-account-outline"}
      ],
      validLogin: true,
      validRegister: true,
      show1: false,
      show2: false,
      success_mail: false,
      modal_mail: false,
      invalid_credentials: false,
      register_succeeded: false,
      color_default: 'rgba(18,210,175)',
      loading_btn: false,
      formLogin: {
        email: "",
        password: ""
      },
      formRegister: {
        firstName: "",
        lastName: "",
        email: "",
        cpf: "",
        password: "",
        verify: ""
      },
      
      
      emailRule: [
        v => !!v || "Digite o seu E-mail",
        v => /.+@.+\..+/.test(v) || "E-mail inválido"
      ],
      passwordRule: [
        v => !!v || "Digite sua senha",
        v => (v && v.length >= 5) || "No mínimo 5 caracteres"
      ],
      requiredRule: [
        v => !!v || "Essa informação é obrigatória"
      ],
      /*cpfcnpjRule: [
        v => !!v || "Digite o seu CPF",
        v => /(^\d{3}\.\d{3}\.\d{3}\-\d{2}$)|(^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$)/.test(v) || "CPF inválido"
      ],*/
      /*cpfRule: [
        v => !!v || "Digite o seu CPF",
        v => /^\d{3}\.\d{3}\.\d{3}\-\d{2}$/.test(v) || "CPF inválido"
      ],*/
      cpfRule: [
        v => !!v || "Digite o seu CPF",
        v => /^\d{3}\.\d{3}\.\d{3}-\d{2}$/.test(v) || "CPF inválido"
      ],

      rules: {
        verifyPasswordRule: value => !!value || "Confirme a sua senha"
      }
    })
    
  }
</script>
<style scoped>
  .forgot-text {
    cursor: pointer;
    padding-top: 40px;
    color: #40bfff;
    font-weight: bold;
    font-family: 'Quicksand', sans-serif;
  }
  
  .center {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    padding: 10px;
  }
  .hover-card {
    box-shadow: rgba(0, 0, 0, 0.3) 0px 19px 38px, rgba(0, 0, 0, 0.22) 0px 15px 12px !important; 
    
    transition: box-shadow .3s;
  }
  .hover-card:hover {
    box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px 12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 16px 17px, rgba(0, 0, 0, 0.09) 0px -3px 5px !important; 
  }

  .btn {
  flex: 1 1 auto;
  margin: 10px;
  padding: 30px;
  text-align: center;
  text-transform: uppercase;
  transition: 0.5s;
  background-size: 200% auto;
  color: white;
  text-shadow: 0px 0px 10px rgba(0,0,0,0.2);
  /*box-shadow: 0 0 20px teal; */
  border-radius: 10px;
 }

/* Demo Stuff End -> */

/* <- Magic Stuff Start */

.btn:hover {
  background-position: right center; /* change the direction of the change here */
}
.btn-3 {
  background-image: linear-gradient(to right,  #62fa9a 0%, #40bfff 51%, #acf849 100%);
}
</style>
<style lang="scss">
  

  .gamer-border {
	--angle: 0deg;
	
	border: 2px solid;
	border-image: conic-gradient(from var(--angle),rgb(253, 249, 1) , rgb(10, 255, 2), rgb(121, 178, 253),rgba(18,210,175)) 1;
	
	animation: 10s rotate linear infinite;
}

@keyframes rotate {
	to {
		--angle: 360deg;
	}
}

@property --angle {
  syntax: '<angle>';
  initial-value: 0deg;
  inherits: false;
}

  

/*.gradient-border {
  --border-width: 0.01px;

  

  &::after {
    position: absolute;
    content: "";
    top: calc(-1 * var(--border-width));
    left: calc(-1 * var(--border-width));
    z-index: -1;
    width: calc(100% + var(--border-width));
    height: calc(100% + var(--border-width));
    background: linear-gradient(
      60deg,
      hsl(224, 85%, 66%),
      hsl(269, 85%, 66%),
      hsl(314, 85%, 66%),
      hsl(359, 85%, 66%),
      hsl(44, 85%, 66%),
      hsl(89, 85%, 66%),
      hsl(134, 85%, 66%),
      hsl(179, 85%, 66%)
    );
    background-size: 300% 300%;
    background-position: 0 30%;
    border-radius: calc( var(--border-width));
    animation: moveGradient 4s alternate infinite;
  }
}

@keyframes moveGradient {
  50% {
    background-position: 100% 50%;
  }
}


*/
</style>