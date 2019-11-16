<template>
	<div class="login row justify-content-center">
		<div class="col-md-4">
			<div class="card">
				<div class="card-header">Sign up</div>
				<div class="card-body">
					<form @submit.prevent="register">
						<div class="form-group row">
							<label for="name">Name:</label>
							<input type="text" class="form-control" v-model="user.name" placeholder="Name">
						</div>
						<div class="form-group row">
							<label for="email">Email:</label>
							<input type="email" class="form-control" v-model="user.email" placeholder="Email Address">
						</div>
						<div class="form-group row">
							<label for="password">Password:</label>
							<input type="password" class="form-control" v-model="user.password" placeholder="Password">
						</div>
						<div class="form-group row">
							<label for="confirmation">Confirmation Password:</label>
							<input type="password" class="form-control" v-model="user.confirmation" placeholder="Confirmation Password">
						</div>
						<div class="form-group row">
							<input type="submit" class="btn btn-primary btn-block btn-flat" value="Sign up">
						</div>
					</form>
					<div class="errors" v-if="errors">
						<ul>
							<li v-for="(fieldsError, fieldName) in errors" :keys="fieldName">
								{{ fieldsError.join('\n')}}
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import validate from 'validate.js';

	export default {
		name: "register",
		data() {
			return {
				user: {
					name:'',
					email:'',
					password:'',
					confirmation:'',
				},
				errors: null
			}
		},
		methods: {
			register()
			{
				this.errors = null;

				const constraints = this.getConstraints();
				const errors = validate(this.$data.user, constraints);

				if(errors){
					this.errors = errors;
					return;	
				}

				this.$Progress.start();

				axios.post('api/auth/register', this.$data.user)
				.then((response)=>{

					swal.fire({
                        type: 'success',
                        title: 'User Created in successfully'
                    });

                    this.$Progress.finish();
					this.$router.push('login');
				})
				.catch((error)=>{
					console.log(error);
					this.$Progress.fail();
				})
			},
			getConstraints()
			{
				return {
					name: {
						presence: true,
						length: {
							minimum: 3,
							message: 'must be at least 3 characters'	
						}	
					},
					email: {
						presence: true,
						email: true	
					},
					password: {
						presence: true,
						equality: "confirmation",
						length: {
							minimum: 6,
							message: "must be at least 6 characters"
						}
					},
					confirmation: {
						presence: true,
						length: {
							minimum: 6,
							message: "must be at least 6 characters"
						}
					}
				}
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