<template>
<div class="members-list">
	<div class="row mb-2">
		<div class="col-sm-6">
			<h1>User Management</h1>
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
						<i class="fa fa-plus" aria-hidden="true"></i> Add New
					</button>
				</span>
				<div class="card-tools">
					<div class="input-group input-group-sm" style="width: 150px;">
						<input type="text" name="table_search" class="form-control float-right" placeholder="Search">

						<div class="input-group-append">
							<button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
						</div>
					</div>
				</div>
			</div>
			<div class="card-body p-0">
				<div class="table-responsive table-hover">
					<table class="table">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Email</th>
								<th>Registration date/time</th>
								<th>Role</th>
								<th>Status</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<template v-if="!users">
								<tr>
									<td colspan="4" class="text-center">No Users Available</td>
								</tr>
							</template>
							<template v-else>
								<tr v-for="user in users.data" :key="user.id">
									<td>{{ user.id }}</td>
									<td>{{ user.name }}</td>
									<td>{{ user.email }}</td>
									<td>{{ user.created_at }}</td>
									<td>{{ user.role }}</td>
									<td>
										<template v-if="user.status === 'Active'">
											<span class="badge bg-success">
												{{ user.status }}
											</span>
										</template>
										<template v-else>
											<span class="badge bg-warning">
												{{ user.status }}
											</span>
										</template>
									</td>
									<td>
										<a href="#" class="btn btn-info btn-sm" 
											@click="editModal(user)">
											<i class="fas fa-pencil-alt"></i>
										</a>
										<a href="#" class="btn btn-danger btn-sm"
											@click="deleteUser(user.id)">
											<i class="fas fa-trash"></i>
										</a>
									</td>
								</tr>
							</template>
						</tbody>
					</table>
				</div>
			</div>
			<div class="card-footer clearfix">
				<pagination :data="users.data" @pagination-change-page="users"></pagination>
			</div>
		</div>
		<!--start-->
		<div class="modal" id="userModal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" v-show="!editmode">Add New</h5>
						<h5 class="modal-title" v-show="editmode">Update User's Info</h5>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<form @submit.prevent="editmode ? updateUser() : createUser()">
						<div class="modal-body">
							<div class="input-group mb-3">
								<input 	type="text" 
										class="form-control" 
										:class="{ 'is-invalid': form.errors.has('name') }"
										v-model="form.name"
										name="name"
										placeholder="Name">
										<div class="input-group-append">
								            <div class="input-group-text">
								            	<span class="fas fa-user"></span>
								            </div>
							          	</div>
										<has-error :form="form" field="name"></has-error>
							</div>
							<div class="input-group mb-3">
								<input 	type="email" 
										class="form-control"
										:class="{ 'is-invalid': form.errors.has('email') }" 
										v-model="form.email"
										name="email"
										placeholder="Email">
										<div class="input-group-append">
								            <div class="input-group-text">
								            	<span class="fas fa-envelope"></span>
								            </div>
							          	</div>
										<has-error :form="form" field="email"></has-error>
							</div>
							<div class="input-group mb-3">
								<input  type="password" 
										class="form-control"
										:class="{ 'is-invalid': form.errors.has('password') }" 
										v-model="form.password"
										name="password"
										placeholder="Password">
										<div class="input-group-append">
								            <div class="input-group-text">
								            	<i class="fa fa-key" aria-hidden="true"></i>
								            </div>
							          	</div>
										<has-error :form="form" field="password"></has-error>
							</div>
							<div class="input-group mb-3">
								<select name="role" 
									v-model="form.role" 
									class="form-control select2" 
									:class="{'is-invalid': form.errors.has('role') }"
									>
									<option value="">--Choose Role--</option>
									<option value="Admin">Admin</option>
									<option value="User">Standard User</option>
									<option value="Author">Author</option>
								</select>
								<has-error :form="form" field="role"></has-error>
							</div>
							<div class="input-group mb-3">
								<select name="status" 
									v-model="form.status" 
									id="status" 
									class="form-control select2" 
									:class="{ 
										'is-invalid': form.errors.has('status') 
									}">
									<option value="">--Choose Status--</option>
									<option value="Active">Active</option>
									<option value="InActive">InActive</option>
								</select>
								<has-error :form="form" field="status"></has-error>
							</div>
							<div class="input-group mb-3">
								<button v-show="editmode" 
										type="submit" 
										class="btn btn-success btn-sm mr-auto">
										Update
								</button>
								<button v-show="!editmode" 
										type="submit" 
										class="btn btn-success btn-sm mr-auto">
										Create
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
					password: '',
					role: '',
					status: '',
				})
			}
		},
		mounted() {
			if (this.users.length) {
				return;
			}
			this.getUsers();
		},
		computed: {
			users(){
				//console.log(this.$store.getters.users);
				return this.$store.getters.users;
			},
			currentUser() {
				return this.$store.getters.currentUser;
			}
		},	
		methods: {
			getUsers(page = 1){
			    this.$store.dispatch('getUsers',{
			        page: page
			    });
			},
			editModal(user){
				this.editmode = true;
				this.form.reset();
				$('#userModal').modal('show');
				this.form.fill(user);
			},
			newModal(){
				this.editmode = false;
				this.form.reset();
				$('#userModal').modal('show');
			},
			createUser(){
				this.$Progress.start();

				this.form.post('/api/user/create')
				.then((response)=>{
					Fire.$emit('AfterUserCreate');
					$('#userModal').modal('hide');
					swal.fire('Add User','User created in successfully','success');
					this.$Progress.finish();
				})
				.catch((error)=>{
					console.log(error);
					this.$Progress.fail();
				})
			},
			updateUser(){
				this.$Progress.start();
				this.form.put('/api/user/update/'+this.form.id)
				.then(() => {
					Fire.$emit('AfterUserEdit');
					$('#userModal').modal('hide');
					swal.fire('Updated!','Information has been updated.','success');
					this.$Progress.finish();
				})
				.catch(() => {
					this.$Progress.fail();
				});
			},
			deleteUser(id){
				swal.fire({
					title: 'Are you sure?',
					text: "You won't be able to revert this!",
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {

					this.$Progress.start();

					if (result.value) {
						axios.post('/api/user/delete/'+id).
						then(()=>{
							Fire.$emit('AfterUserDelete');
							swal.fire('Deleted!','Your customer has been deleted.','success'
								)
							this.$Progress.finish();
						}).catch(()=> {
							swal.fire("Failed!", "There was something wrong.", "warning");
							this.$Progress.fail();
						});
					}
				}).catch((error)=>{
					this.$Progress.fail();
				})
			}
		},
		created() {
			Fire.$on('AfterUserCreate',() => {
				this.$store.dispatch('getUsers');
			});
			Fire.$on('AfterUserEdit',() => {
				this.$store.dispatch('getUsers');
			});
			Fire.$on('AfterUserDelete',() => {
				this.$store.dispatch('getUsers');
			});
		}	
	}
</script>
<style>

</style>