<template>
	<div>
		<base-card class="mb-5 max-w-lg mx-auto">
			<template slot="body">
				<base-title>Profile Settings</base-title>

				<div class="mb-5">
					<base-label label="Name"></base-label>
					<base-input
						v-model="user.name"
						id="name"
						:error-feedback="(errors && errors.name ? errors.name : '')"
					></base-input>
				</div>

				<div class="mb-5">
					<base-label label="Email" hint="Please contact admin to change/update your email address"></base-label>
					<base-input v-model="user.email" id="email" type="email" disabled></base-input>
				</div>

				<div class="mb-5">
					<base-label label="Phone"></base-label>
					<base-input
						v-model="user.phone"
						id="phone"
						:error-feedback="(errors && errors.phone ? errors.phone : '')"
					></base-input>
				</div>

				<base-button ref="loadingButton" type="button" theme="blue">Update Profile</base-button>
			</template>
		</base-card>

		<base-card class="mb-5 max-w-lg mx-auto">
			<template slot="body">
				<base-title>Change Password</base-title>

				<base-alert class="mb-5" v-if="passwordAlertMessage">
					<span slot="icon">
						<Zondicon icon="checkmark-outline" class="text-xl fill-current mr-4 svg-icon"></Zondicon>
					</span>
					<span slot="content">
						<span class="font-semibold block mr-2 mb-1">Password Changed!</span>
						Please login with the new password next time.
					</span>
				</base-alert>

				<div class="mb-5">
					<base-label label="Current Password"></base-label>
					<base-input
						v-model="password.old"
						id="old"
						type="password"
						:error-feedback="(errors && errors.old ? errors.old : '')"
					></base-input>
				</div>

				<div class="mb-5">
					<base-label label="New Password"></base-label>
					<base-input
						v-model="password.password"
						id="new_password"
						type="password"
						:error-feedback="(errors && errors.password ? errors.password : '')"
					></base-input>
				</div>

				<div class="mb-5">
					<base-label label="Confirm New Password"></base-label>
					<base-input
						v-model="password.password_confirmation"
						id="password_confirmation"
						type="password"
						:error-feedback="(errors && errors.password_confirmation ? errors.password_confirmation : '')"
					></base-input>
				</div>

				<base-button
					ref="loadingButton"
					type="button"
					theme="blue"
					:onClick="updatePassword"
				>Change Password</base-button>
			</template>
		</base-card>
	</div>
</template>

<script>
import BaseCard from "../components/BaseCard.vue";
import BaseTitle from "../components/BaseTitle.vue";
import BaseAlert from "../components/BaseAlert.vue";
import BaseLabel from "../components/BaseLabel.vue";
import BaseInput from "../components/BaseInput.vue";
import BaseButton from "../components/BaseButton.vue";

let config = {
	headers: { "X-CSRF-TOKEN": window.Laravel ? window.Laravel.csrfToken : "" }
};

export default {
	name: "AccountSettings",

	components: {
		BaseCard,
		BaseTitle,
		BaseAlert,
		BaseInput,
		BaseLabel,
		BaseButton
	},

	beforeRouteEnter(to, from, next) {
		axios.get("/api/user", config).then(response => {
			next(vm => vm.setData(response.data));
		});
	},

	beforeRouteUpdate(to, from, next) {
		axios.get("/api/user", config).then(response => {
			this.setData(response.data);
			next();
		});
	},

	data() {
		return {
			user: {
				name: "",
				email: "",
				phone: ""
			},
			userId: null,
			password: {
				old: "",
				password: "",
				password_confirmation: ""
			},
			passwordAlertMessage: false,
			errors: {}
		};
	},

	mounted() {},

	methods: {
		setData(response) {
			this.user = response;
			this.userId = response.id;
		},

		updateUser() {},

		updatePassword() {
			this.$refs.loadingButton.startLoading();
			axios
				.put("/api/user/changepassword", this.password, config)
				.then(response => {
					this.errors = {};
					this.password = {};

					this.passwordAlertMessage = true;

					this.$refs.loadingButton.stopLoading();

					this.$snack.success({
						text: "Password updated successfully",
						button: "ok"
					});
				})
				.catch(errors => {
					this.$refs.loadingButton.stopLoading();
					this.errors = errors.response.data.errors;
				});
		}
	}
};
</script>

<style scoped>
</style>