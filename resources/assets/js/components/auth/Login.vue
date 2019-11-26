<template>
<div class="login-box">
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in</p>
            <form @submit.prevent="authenticate">

            <div class="input-group mb-3">
                <input  type="email" 
                        v-model="form.email" 
                        class="form-control" 
                        placeholder="Email Address">
                <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>

            <div class="input-group mb-3">
                <input  type="password" 
                        v-model="form.password" 
                        class="form-control" 
                        placeholder="Password">
                <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-lock"></span>
                  </div>
                </div>
            </div>

            <div class="row">
                <div class="col-8">
                    <div class="icheck-primary">
                        <input type="checkbox" id="remember">
                        <label for="remember">
                            Remember Me
                        </label>
                    </div>
                </div>
                <div class="col-4">
                    <button type="submit" class="btn btn-success btn-sm">Sign In</button>
                </div>
            </div>
            </form>
            <div class="errors mt-3 pb-3" v-if="authError">
                <p class="text-center">
                    {{ authError }}
                </p>
            </div>
            <p class="mb-1">
                <a href="#">I forgot my password</a>
            </p>
            <p class="mb-0">
                <a href="#" class="text-center">Register a new membership</a>
            </p>
        </div>
    </div>
</div>
</template>

<script>
	import {login} from '../../helpers/auth';

	export default {
		name: "login",
        data() {
            return {
                form: {
                    email: '',
                    password: ''
                },
                error: null
            };
        },
        methods: {
            authenticate() {
            	this.$store.dispatch('login');

            	login(this.$data.form)
                .then((res) => {
                    this.$store.commit("loginSuccess", res);
                    this.$router.push({path: '/'});
                })
                .catch((error) => {
                    this.$store.commit("loginFailed", {error});
                });
            }
        },
        computed:{
        	authError(){
        		return this.$store.getters.authError;
        	}
        }
    }
</script>

<style scoped>
.errors {
    background: lightcoral;
    border-radius:5px;
    padding: 21px 0 2px 0;
}
</style>