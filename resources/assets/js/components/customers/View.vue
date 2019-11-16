<template>
	<div class="customer-view">
		<div class="user-img">
			<img src="https://www.scottsdaleazestateplanning.com/wp-content/uploads/2018/01/user.png" alt="profile photo" />
		</div>
		<div class="user-info">
			<table class="table">
				<tr>
					<td>ID</td>
					<td>{{ customer.id}}</td>
				</tr>
				<tr>
					<td>First name</td>
					<td>{{ customer.first_name}}</td>
				</tr>
				<tr>
					<td>Last name</td>
					<td>{{ customer.last_name}}</td>
				</tr>
				<tr>
					<td>Email</td>
					<td>{{ customer.email}}</td>
				</tr>
				<tr>
					<td>Phone</td>
					<td>{{ customer.phone}}</td>
				</tr>
			</table>
		</div>

	</div>
</template>

<script>
    export default {
        name: 'customer-view',
        created() {
            if (this.customers.length) {
                this.customer = this.customers.find((customer) => customer.id == this.$route.params.id);
            } else {
                axios.get(`/api/customer/${this.$route.params.id}`)
                .then((response) => {
                    this.customer = response.data.customer
                });
            }
        },
        data() {
            return {
                customer: null
            };
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

<style scoped>
	.customer-view {
	    display: flex;
	    align-items: center;
	}
	.user-img {
	    flex: 1;
	}
	.user-img img {
	    max-width: 160px;
	}
	.user-info {
	    flex: 3;
	}
</style>