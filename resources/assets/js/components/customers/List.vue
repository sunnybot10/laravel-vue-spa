<template>
	<div class="customer-list">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Customer Management</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card card-default">
					<div class="card-header">
	                	<span class="card-title">
	                		<button type="button" 
			                  		class="btn btn-success btn-sm" 
			                  		@click="newModal()">
			                  		<i class="fa fa-plus" aria-hidden="true"></i>
			                  		Add New
			             	</button>
			            </span>
		                <div class="card-tools">
		                  <div class="input-group input-group-sm" style="width: 200px;">
		                    <input 	type="text" 
		                    		name="table_search" 
		                    		class="form-control float-right" 
		                    		placeholder="Search">
		                    <div class="input-group-append">
		                      	<button type="submit" class="btn btn-default">
		                      		<i class="fas fa-search"></i>
		                      	</button>
		                    </div>
		                  </div>
		                </div>
              		</div>
					<div class="card-body p-0">
					<div class="table-responsive">
						<table class="table">
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Email</th>
								<th>Phone</th>
								<th>Action</th>
							</tr>
							<template v-if="!customers">
								<tr>
									<td colspan="4" class="text-center">No Customer Available</td>
								</tr>
							</template>
							<template v-else>
								<tr v-for="customer in customers" :key="customer.id">
									<td>{{ customer.id }}</td>
									<td>{{ customer.name }}<br>
										<small class="text-muted">Created : {{ customer.created_at | myDate }}</small>
									</td>
									<td><router-link :to="`/customer/${customer.id}`">{{ customer.email }}</router-link></td>
									<td>{{ customer.phone }}</td>
									<td>
										<router-link :to="`/customer/${customer.id}`"
											class="btn btn-primary btn-sm">
											<i class="fas fa-folder"></i>
										</router-link>
										<a href="#" class="btn btn-info btn-sm" 
											@click="editModal(customer)">
											<i class="fas fa-pencil-alt"></i>
										</a>
										<a href="#" class="btn btn-danger btn-sm"
											@click="deleteCustomer(customer.id)">
											<i class="fas fa-trash"></i>
										</a>
									</td>
								</tr>	
							</template>
						</table>
						</div>
					</div>
					<div class="card-footer clearfix">
		              <!--<pagination :data="laravelData" @pagination-change-page="getResults"></pagination>
		              -->
		            </div>
				</div>
				<!--start of modal-->
				<div class="modal" id="addNew">
					<div class="modal-dialog">
						<div class="modal-content">
							<!-- Modal Header -->
							<div class="modal-header">
								<h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New</h5>
								<h5 class="modal-title" v-show="editmode" id="addNewLabel">Update Customer's Info</h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>
							<form @submit.prevent="editmode ? updateCustomer() : createCustomer()">
								<div class="modal-body">
									<div class="input-group mb-3">
							          <input type="text" 
							          		class="form-control"
							          		:class="{ 'is-invalid': form.errors.has('name') }"
							          		v-model="form.name"
							          		name="name" 
							          		placeholder="Full name e.g Sunny Mathole">
							          <div class="input-group-append">
							            <div class="input-group-text">
							              <span class="fas fa-user"></span>
							            </div>
							          </div>
							          <has-error :form="form" field="name">
							          </has-error>
							        </div>

									<div class="input-group mb-3">
							          <input type="text" 
							          		class="form-control"
							          		:class="{ 'is-invalid': form.errors.has('email') }"
							          		v-model="form.email"
							          		name="email" 
							          		placeholder="Email e.g example@gmail.com">
							          <div class="input-group-append">
							            <div class="input-group-text">
							              <span class="fas fa-envelope"></span>
							            </div>
							          </div>
							          <has-error :form="form" field="email">
							          </has-error>
							        </div>
									<div class="input-group mb-3">
							          <input type="text" 
							          		class="form-control"
							          		:class="{ 'is-invalid': form.errors.has('phone') }"
							          		v-model="form.phone"
							          		v-mask="'(999) 9999 999'"
							          		name="phone" 
							          		placeholder="Phone e.g 071 1152 321">
							          <div class="input-group-append">
							            <div class="input-group-text">
							              <span class="fas fa-phone"></span>
							            </div>
							          </div>
							          <has-error :form="form" field="phone">
							          </has-error>
							        </div>
							        <div class="input-group mb-3">
							        	<textarea 	class="form-control" 
							        				rows="5"
							        				:class="{ 'is-invalid': form.errors.has('address') }"
							        				v-model="form.address"
							        				name="address"
							        				placeholder="Address e.g 25651 Mayert Shoal Lutherbury, TN 19380" 
							        				></textarea>
							        </div>
							        <div class="input-group mb-3">
							          <input type="text" 
							          		class="form-control"
							          		:class="{ 'is-invalid': form.errors.has('birthday') }"
							          		v-model="form.birthday"
							          		name="birthday" 
							          		placeholder="birthday e.g 1988-10-22"
							          		v-mask="'9999-99-99'">
							          <div class="input-group-append">
							            <div class="input-group-text">
							              <span class="fa fa-calendar-alt"></span>
							            </div>
							          </div>
							        </div>
							        <div class="input-group mb-3">
							        	<button v-show="editmode" type="submit" class="btn btn-success mr-auto btn-sm">Update
										</button>
										<button v-show="!editmode" type="submit" class="btn btn-success mr-auto btn-sm">Create
										</button>
										<button type="button" class="btn btn-info btn-sm" data-dismiss="modal">Cancel
										</button>
							        </div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
										Close
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<!--end of modal-->
			</div>
		</div>
	</div>

</template>
<script>
	export default {
		name: 'list',
		data() {
			return {
				editmode: false,
				form: new Form({
					id:'',
					name: '',
					email: '',
					phone: '',
					address: '',
					birthday: '',
				}),
				errors: null,
			}
		},		
		mounted() {
			if (this.customers.length) {
				return;
			}
			this.$store.dispatch('getCustomers');
		},
		computed: {
			customers() {
				return this.$store.getters.customers;
			},
			currentUser() {
				return this.$store.getters.currentUser;
			}
		},
		methods: {
			editModal(customer){
				this.editmode = true;
				this.form.reset();
				$('#addNew').modal('show');
				this.form.fill(customer);
			},
			newModal(){
				this.editmode = false;
				this.form.reset();
				$('#addNew').modal('show');
			},
			createCustomer(){
				this.$Progress.start();

				this.form.post('/api/customer/create')
				.then((response)=>{
					Fire.$emit('AfterCreate');
					$('#addNew').modal('hide');
					swal.fire('Add Customer','Customer created in successfully','success');
					this.$Progress.finish();
				})
				.catch((error)=>{
					this.$Progress.fail();
				})
			},
			updateCustomer(){

				this.$Progress.start();
				this.form.put('/api/customer/update/'+this.form.id)
				.then(() => {
					Fire.$emit('AfterCreate');
					$('#addNew').modal('hide');
					swal.fire('Updated!','Information has been updated.','success');
					this.$Progress.finish();
				})
				.catch(() => {
					this.$Progress.fail();
				});
			},
			deleteCustomer(id){
				swal.fire({
					title: 'Are you sure?',
					text: "You won't be able to revert this!",
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {

					if (result.value) {
						axios.post('/api/customer/delete/'+id).
						then(()=>{
							swal.fire('Deleted!','Your customer has been deleted.','success'
								)
							Fire.$emit('AfterCreate');
						}).catch(()=> {
							swal.fire("Failed!", "There was something wrong.", "warning");
						});
					}
				})
			}
		},
		created() {
			Fire.$on('AfterCreate',() => {
				this.$store.dispatch('getCustomers');
			});
		}
	}
</script>

<style>
.btn-wrapper {
	text-align: right;
	margin-bottom: 20px;
}
.errors {
	background: lightcoral;
	border-radius:5px;
	padding: 21px 0 2px 0;
}
</style>