<template>
	<div class="product-list">
		<div class="col-md-12">
			<div class="card card-default">
				<div class="card-header">
					Product Management
				</div>
				<div class="card-body">
					<div class="btn-wrapper">
						<button type="button" class="btn btn-primary btn-sm" @click="newModal()">
							<i class="fa fa-plus" aria-hidden="true"></i> Add Product
						</button>
					</div>
					<div class="table-responsive">
					<table class="table mt-2">
						<thead>
							<tr>
								<th>ID</th>
								<th>Sku</th>
								<th>Registration date/time</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<template v-if="!products">
								<tr>
									<td colspan="4" class="text-center">No Products Available</td>
								</tr>
							</template>
							<template v-else>
								<tr v-for="product in products" :key="product.id">
									<td>{{ product.id }}</td>
									<td>{{ product.sku }}</td>
									<td>{{ product.created_at }}</td>
									<td>
										<span class="pr-3">
											<button type="button" 
													class="btn btn-success btn-sm" 
													@click="editModal(product)">
											<i class="fa fa-edit blue" aria-hidden="true"></i> Edit
											</button>
										</span>
										<span class="pr-3">
											<button type="button" 
													class="btn btn-danger btn-sm" 
													@click="deleteProduct(product.id)">
											<i class="fa fa-trash" aria-hidden="true"></i> Delete
											</button>
										</span>
									</td>
								</tr>
							</template>
						</tbody>
					</table>
					</div>
					<!-- The Modal -->
					<div class="modal" id="productModal">
						<div class="modal-dialog">
							<div class="modal-content">
								<!-- Modal Header -->
								<div class="modal-header">
									<h5 class="modal-title" v-show="!editmode">Add New</h5>
									<h5 class="modal-title" v-show="editmode">Update Product's Info</h5>
									<button type="button" class="close" data-dismiss="modal">&times;</button>
								</div>
								<form @submit.prevent="editmode ? updateProduct() : createProduct()">
									<!-- Modal body -->
									<div class="modal-body">
										<div class="form-group">
											<input 	type="text" 
											class="form-control" 
											:class="{ 'is-invalid': form.errors.has('sku') }"
											v-model="form.sku"
											sku="sku"
											placeholder="sku">
											<has-error :form="form" field="sku"></has-error>
										</div>
									</div>
									<!-- Modal footer -->
									<div class="modal-footer">
										<button v-show="editmode" 
												type="submit" 
												class="btn btn-success mr-auto">
										<i class="fa fa-edit" aria-hidden="true"></i> Edit
										</button>
										<button v-show="!editmode" 
												type="submit" 
												class="btn btn-primary mr-auto">
										<i class="fa fa-plus" aria-hidden="true"></i> Create
										</button>
										<button type="button" 
												class="btn btn-danger" 
												data-dismiss="modal">
											Close
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<!-- End of the Modal -->
				</div>
				<div class="card-footer">
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		product: 'list',
		data() {
			return {
				editmode: false,
				form: new Form({
					id:'',
					sku: '',
				})
			}
		},
		mounted() {
			if (this.products.length) {
				return;
			}
			this.$store.dispatch('getProducts');
		},
		computed: {
			products() {
				return this.$store.getters.products;
			},
			currentUser() {
				return this.$store.getters.currentUser;
			}
		},	
		methods: {
			editModal(product){
				this.editmode = true;
				this.form.reset();
				$('#productModal').modal('show');
				this.form.fill(product);
			},
			newModal(){
				this.editmode = false;
				this.form.reset();
				$('#productModal').modal('show');
			},
			createProduct(){
				this.$Progress.start();

				this.form.post('/api/product/create')
				.then((response)=>{
					Fire.$emit('AfterProductCreate');
					$('#productModal').modal('hide');
					swal.fire('Add Product','Product created in successfully','success');
					this.$Progress.finish();
				})
				.catch((error)=>{
					this.$Progress.fail();
				})
			},
			updateProduct(){
				this.$Progress.start();
				this.form.put('/api/product/update/'+this.form.id)
				.then(() => {
					Fire.$emit('AfterProductEdit');
					$('#productModal').modal('hide');
					swal.fire('Updated!','Information has been updated.','success');
					this.$Progress.finish();
				})
				.catch(() => {
					this.$Progress.fail();
				});
			},
			deleteProduct(id){
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
						axios.post('/api/product/delete/'+id).
						then(()=>{
							Fire.$emit('AfterProductDelete');
							swal.fire('Deleted!','Your product has been deleted.','success'
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
			Fire.$on('AfterProductCreate',() => {
				this.$store.dispatch('getProducts');
			});
			Fire.$on('AfterProductEdit',() => {
				this.$store.dispatch('getProducts');
			});
			Fire.$on('AfterProductDelete',() => {
				this.$store.dispatch('getProducts');
			});
		}	
	}
</script>

<style>

</style>