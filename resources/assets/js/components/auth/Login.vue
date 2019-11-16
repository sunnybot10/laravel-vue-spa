<template>
	<div class="login row justify-content-center">
		<div class="col-md-4">
			<div class="card">
				<div class="card-header">Login</div>
				<div class="card-body">
					<form @submit.prevent="authenticate" autocomplete="off">
						<div class="form-group row">
							<label for="email">Email:</label>
							<input type="email" v-model="form.email" class="form-control" placeholder="Email Address" autocomplete="off">
						</div>
						<div class="form-group row">
							<label for="password">Password:</label>
							<input type="password" v-model="form.password" class="form-control" placeholder="Password" autocomplete="off">
						</div>
						<div class="form-group row">
							<input type="submit" class="btn btn-primary btn-block btn-flat" value="Login">
						</div>
                    </form>
					<div class="errors" v-if="authError">
                        <p class="text-center">
                            {{ authError }}
                        </p>
                    </div>
				</div>
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