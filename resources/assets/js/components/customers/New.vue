<template>
	<div class="customer-new">
		<form @submit.prevent="add">
			<div class="form-group">
			  <label for="firstName">First name</label>
			  <input type="text" class="form-control" v-model="customer.first_name">
			</div>

			<div class="form-group">
			  <label for="lastName">Last name</label>
			  <input type="text" class="form-control" v-model="customer.last_name">
			</div>

			<div class="form-group">
			  <label for="email">Email</label>
			  <input type="text" class="form-control" v-model="customer.email">
			</div>

			<div class="form-group">
			  <label for="phone">Phone</label>
			  <input type="text" class="form-control" v-model="customer.phone">
			</div>

			<div class="form-group">
				<router-link to="/customer">Cancel</router-link>
				<input type="submit" value="Create" class="btn btn-primary">
			</div>
		</form>
		<div class="errors" v-if="errors">
			<ul>
				<li v-for="(fieldsError, fieldName) in errors" :keys="fieldName">
					<strong>{{ fieldName }}</strong> {{ fieldsError.join('\n')}}
				</li>
			</ul>
		</div>
	</div>
</template>

<script>
	import validate from 'validate.js';

	export default{
		name: 'new',
		data() {
			return {
				customer: {
					first_name: '',
					last_name: '',
					email: '',
					phone: '',
				},
				errors: null
			}
		},
		computed: {
			currentUser() {
                return this.$store.getters.currentUser;
            }
		},
		methods: {
			add(){
				this.errors = null;

				const constraints = this.getConstraints();
				const errors = validate(this.$data.customer, constraints);
				
				if(errors){
					this.errors = errors;
					return;	
				}

				axios.post('/api/customer/create', this.$data.customer)
				.then((response)=>{
					this.$router.push('/customer');
				})
				.catch((error)=>{
					console.log(error);
				})
			},
			getConstraints(){
				return {
					first_name: {
						presence: true,
						length: {
							minimum: 3,
							message: 'must be at least 3 characters'	
						}	
					},
					last_name: {
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
					phone: {
						presence: true,
						numericality: true,
						length: {
							minimum: 10,
							message: 'must be at least 10 characters'	
						}		
					}
				}
			}
		}
	}
</script>

<style>
	.errors {
	    background: lightcoral;
	    border-radius:5px;
	    padding: 21px 0 2px 0;
	}
</style>