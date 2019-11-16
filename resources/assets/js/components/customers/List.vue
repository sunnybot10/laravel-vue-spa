<template>
	<div>
		<div class="btn-wrapper">
			<router-link to="/customer/new" class="btn btn-primary btn-sm">New</router-link>
		</div>
		<div class="table-responsive">
			<table class="table">
				<tr>
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
						<td>{{ customer.first_name }} {{ customer.last_name }} </td>
						<td>{{ customer.email }}</td>
						<td>{{ customer.phone }}</td>
						<td>
							<router-link :to="`/customer/${customer.id}`">View</router-link>
						</td>
					</tr>	
				</template>
			</table>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'list',		
		mounted() {
			if (this.customers.length) {
                return;
            }
			this.$store.dispatch('getCustomers');
		},
		computed: {
			customers() {
				return this.$store.getters.customers;
			}
		}
	}
</script>

<style scoped>
	.btn-wrapper {
	    text-align: right;
	    margin-bottom: 20px;
	}
</style>