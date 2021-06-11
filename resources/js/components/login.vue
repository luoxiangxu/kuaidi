<template>
          <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="card card-shadowed p-50 w-400 mb-0" style="max-width: 100%">
                <h5 class="text-uppercase text-center">Login</h5>
                <br><br>

                <form>
                  <ul class="list-group alert alert-danger mb-2" v-if="error != null">
                    <li class="list-group-item ml-2">
                        {{error}}
                    </li>
                  </ul>
                  <div class="form-group">
                    <input type="text" class="form-control" placeholder="Email" v-model="email">
                  </div>

                  <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" v-model="password">
                  </div>

                  <div class="form-group flexbox py-10">
                    <a class="text-muted hover-primary fs-13" href="/password/reset">Forgot password?</a>
                  </div>

                  <div class="form-group">
                    <button class="btn btn-bold btn-block btn-primary" @click="attemptLogin()" :disabled="!isValidLoginForm" type="button">Login</button>
                  </div>
                </form>

                <!-- <div class="divider">Or Sign In With</div>
                <div class="text-center">
                  <a class="btn btn-circular btn-sm btn-facebook mr-4" href="#"><i class="fa fa-facebook"></i></a>
                  <a class="btn btn-circular btn-sm btn-google mr-4" href="#"><i class="fa fa-google"></i></a>
                  <a class="btn btn-circular btn-sm btn-twitter" href="#"><i class="fa fa-twitter"></i></a>
                </div> -->

                <hr class="w-30">

                <p class="text-center text-muted fs-13 mt-20">Don't have an account? <a href="/register">Sign up</a></p>
              </div>
            </div>
          </div>
</template>

<script>
  import axios from 'axios'
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data(){
          return {
            email:'',
            password:'',
            error:null,
          }
        },
        computed: {
          isValidLoginForm(){
            return this.emailisValid() && this.password
          }
        },
        methods:{
          emailisValid(){
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.email))
              {
                return (true)
              }else{
                return false
              }
          },
          attemptLogin(){
            axios.post('/login',{
              email:this.email,password:this.password
            }).then(resp =>{
              location.replace('/homepage')
            }).catch(error => {
              if(error.response.status == 422){
                this.error = null
                this.error = "User name or password wrong"
              }else{
                this.error = null
                this.error = "something went wrong please refresh"
              }
            })
          }
        }
    }
</script>