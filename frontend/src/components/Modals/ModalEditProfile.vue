<template>
  <div>
      <v-dialog
      v-model="dialog"
      persistent
      max-width="700"
    > 
      <v-card :loading="loading">
        <template slot="progress">
          <v-progress-linear
            :color="color"
            height="10"
            indeterminate
          ></v-progress-linear>
        </template>
       <v-card-title class="title-modal" v-if="!loading">
          <strong >Editar Perfil</strong>
          <v-spacer></v-spacer>
           <img width="30" src="../../assets/images/sicoobicon.png"/>
        </v-card-title>
        <v-card-title class="title-modal" v-else>
          <strong>Salvando</strong>
          <v-spacer></v-spacer>
           <img width="50" src="../../assets/images/loading.gif"/>
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text class="mt-7" v-if="loading">
          <v-row align="center" justify="center">  
            <v-col
              cols="12"
            >
            <v-alert
              :color="color"
              border="left"
              elevation="3"
              dark
              icon="mdi-content-save"
            >
              <span>Espera só um pouquinho</span>
            </v-alert>
            </v-col>
          </v-row>    
        </v-card-text>
        <v-card-text class="mt-4" v-else style="font-family: 'Quicksand', sans-serif; font-weight:700">
        <v-form ref="form" v-model="valid" lazy-validation>
          
          <v-row>
            <v-col cols="12" sm="6" md="6">
                <v-text-field  v-model="item.name" :rules="requiredRule" label="Nome" :color="color" name="register_first_name" maxlength="20" required></v-text-field>
            </v-col>
            <v-col cols="12" sm="6" md="6">
                <v-text-field v-model="item.last_name" :rules="requiredRule" label="Sobrenome" :color="color" name="register_last_name" maxlength="20" required></v-text-field>
            </v-col>
            <v-col cols="12" sm="6" md="6">
                <v-text-field v-model="item.email" :rules="emailRule" label="E-mail" :color="color" name="register_email" required></v-text-field>
            </v-col>
            <v-col cols="12" sm="6" md="6">
                <v-text-field-simplemask
                  label= "CPF"
                  v-model="item.cpf"
                  v-bind:properties="{
                   color: color,
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
              <v-text-field v-model="item.role" :rules="requiredRule" label="Cargo na Cooperativa" :color="color" name="register_role" maxlength="50" required></v-text-field>
            </v-col>
           <v-col cols="12"> 
            <v-tooltip right>
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                v-bind="attrs" v-on="on"
                color="orange"
                dark
                small
                @click="change_password = !change_password"
                >
                  <strong>Minha Senha</strong>
                  <v-icon>{{change_password ? 'mdi-lock-minus' : 'mdi-lock-plus'}}</v-icon>
                </v-btn>
              </template>
              <span>{{change_password ? 'Fechar Cartão de Senha' : 'Abrir Cartão de Senha'}}</span>
            </v-tooltip>
            </v-col>
            <v-slide-y-transition>
              <v-card  style="font-family: 'Quicksand', sans-serif;" v-if="change_password" class="mx-auto pa-2" elevation="10" color="yellow lighten-4">
                <v-card-title color="orange" style="font-weight:bold">
                  Alterar Senha 
                  <v-tooltip right>
                    <template v-slot:activator="{ on, attrs }">
                      <v-icon class="mx-2" color="orange" v-bind="attrs" v-on="on">mdi-alert-octagon-outline</v-icon>
                    </template>
                    <span>Essa ação é irreversível</span>
                  </v-tooltip>
                </v-card-title>
                <v-card-subtitle>
                  A sua nova senha entrará em vigor no seu próximo Login.   
                </v-card-subtitle>
                <v-card-text style="font-weight:bold">
                  <v-row align="center" justify="center" > 
                    <v-col cols="12">
                      <v-text-field v-model="item.password" :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'" :rules="passwordRule" :type="show ? 'text' : 'password'" name="register_password" label="Nova senha"  counter color="orange" @click:append="show = !show"></v-text-field>
                    </v-col>
                    <v-col cols="12">
                      <v-text-field block @keyup.enter="editProfile()" v-model="item.verify" :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'" :rules="[rules.verifyPasswordRule, matchPasswords]" :type="show ? 'text' : 'password'" name="verify_password" label="Confirme a nova senha" color="orange" counter @click:append="show = !show"></v-text-field>
                    </v-col>
                  </v-row>
                </v-card-text>
              </v-card>
            </v-slide-y-transition>  
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
            @click="closeModal()"
          >
            Cancelar
          </v-btn>
          <v-btn
            :color="color"
            text
            @click="editProfile()"
          >
            Salvar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>

export default {
    props: ['open', 'user'],
    components: {},
    data () {
        return {
            color: 'blue',
            valid: true,
            dialog: false,
            change_password: false,
            loading: false,
            show: false,
            item: {
              name: "",
              full_name: "",
              last_name: "",
              email: "",
              cpf: "",
              role: "",
              password: "",
              verify: ""
            },
            /* RULES */
            requiredRule: 
            [
              v => (!!v)  || "Essa informação é obrigatória"
            ],
            cpfRule: [
              v => !!v || "Digite o seu CPF",
              v => /^\d{3}\.\d{3}\.\d{3}-\d{2}$/.test(v) || "CPF inválido"
            ],
            emailRule: [
              v => !!v || "Digite o seu E-mail",
              v => /.+@.+\..+/.test(v) || "E-mail inválido"
            ],
            passwordRule: [
              v => !!v || "Digite sua senha",
              v => (v && v.length >= 5) || "No mínimo 5 caracteres",
              v => /[0-9]/.test(v) || "É necessário ao menos um número",
              v => /\W|_/.test(v) || "É necessário ao menos um caracter especial"
            ],
            rules: {
              verifyPasswordRule: value => !!value || "Confirme a sua senha"
            }
        }
        
    },
    watch: {
      open: function () {
        this.dialog = this.open
        if (this.dialog) {
          this.assignUser()
        }
      }
    },
    methods: {
      assignUser () {
        
        Object.assign(Object.assign(this.item, this.defaultItem), this.state_user)
        console.log(this.item)
      },
      editProfile () {
        if (this.$refs.form.validate()) {
            this.loading = true
            this.$http.put(`edit_user/${this.item.id}`, this.item).then((response)=>{
              this.loading = false
              this.$store.dispatch('login', response.data).then(this.$emit('closeModal'))
              if (this.$refs.form) {
                this.$refs.form.reset()
              }
              
            })
          }  
      },
      closeModal () {
        this.$emit('closeModal')
      }
       
    },
    computed: {
      matchPasswords() {
        return this.item.password === this.item.verify || "As senhas não coincidem";
      },
      defaultItem() {
        return {name: '', full_name: '', last_name: this.lastName, email: '', cpf: '', role: '', password: '', verify: ''}
      },
      state_user () {
        return this.$store.state.user
      }
    }
}
</script>

<style scoped>
  .title-modal {
    font-family: 'Quicksand', sans-serif;
    color: rgb(80,150,240)
  }
  .item-select-badge {
    font-weight:bold;
    padding-left:5px
  }
</style>