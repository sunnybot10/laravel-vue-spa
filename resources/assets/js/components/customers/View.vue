<template>
	<div class="col-md-8">
		<div class="card card-default">
			<div class="card-header">
				{{ customer.name}}
			</div>
			<div class="card-body table-responsive p-0">
				<div class="customerView">
					<table class="table">
						<tr>
							<td>ID</td>
							<td>{{ customer.id}}</td>
						</tr>
						<tr>
							<td>Name</td>
							<td>{{ customer.name}}</td>
						</tr>
						<tr>
							<td>Email</td>
							<td>{{ customer.email}}</td>
						</tr>
						<tr>
							<td>Phone</td>
							<td>{{ customer.phone}}</td>
						</tr>
						<tr>
							<td>Address</td>
							<td>{{ customer.address}}</td>
						</tr>
						<tr>
							<td>Birth date</td>
							<td>{{ customer.birthday}}</td>
						</tr>
						<tr>
							<td>Date Created</td>
							<td>{{ customer.created_at}}</td>
						</tr>
						<tr>
							<td>Date Updated</td>
							<td>{{ customer.updated_at}}</td>
						</tr>
						<tr>
							<td colspan="2">
								<router-link to="/customer">
									<button type="button" class="btn btn-default btn-sm">
										Go Back
									</button>
								</router-link>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'customerView',
		data() {
			return {
				customer: {}
			};
		},
		created() {
			if (this.customers.length) {
				this.customer = this.customers.find((customer) => customer.id == this.$route.params.id);
			} else {
				axios.get(`/api/customer/show/${this.$route.params.id}`)
				.then((response) => {
					this.customer = response.data.customer
				});
			}
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			},
			customers() {
				return this.$store.getters.customers;
			}
		}
	}
</script>

<style>
.customerView {
	display: flex;
	align-items: center;
}
</style>