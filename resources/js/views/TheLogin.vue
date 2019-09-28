<template>
	<div>
		<div class="py-16 md:py-32">
			<div class="mx-auto max-w-sm w-full bg-white shadow rounded-lg px-6 lg:px-10 pt-6 pb-10">
				<base-title class="text-center md:text-2xl lg:text-3xl mb-5">Login</base-title>

				<base-alert class="mb-4" v-if="errorMessage" theme="danger">
					<span slot="icon">
						<Zondicon icon="information-outline" class="fill-current mr-4 svg-icon"></Zondicon>
					</span>
					<span slot="content">{{ errorMessage }}</span>
				</base-alert>

				<form @submit.prevent="submitLogin">
					<div class="mb-5">
						<!-- <base-label label="Email"></base-label> -->
						<base-input
							type="email"
							v-model="user.email"
							id="email"
							name="email"
							size="large"
							placeholder="Email address"
							required
						></base-input>
					</div>

					<div class="mb-5">
						<!-- <base-label label="Password"></base-label> -->
						<base-input
							type="password"
							v-model="user.password"
							id="password"
							name="password"
							size="large"
							placeholder="Password"
							required
						></base-input>
					</div>

					<base-button
						ref="loadingButton"
						type="submit"
						theme="blue"
						size="large"
						class="w-full rounded-lg"
					>Log in</base-button>
				</form>

				<p class="my-4">
					<a href="#" class="no-underline text-blue hover:text-blue-dark">Forgot password?</a>
				</p>

				<div class="p-4 bg-blue-lightest rounded-lg mt-4">
					<p class="mb-0 text-grey-darkest text-center">
						Don't have an account?
						<a
							href="/register"
							class="no-underline text-blue hover:text-blue-dark"
						>Get started here!</a>
					</p>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import BaseRadio from "../components/BaseRadio.vue";
import BaseLabel from "../components/BaseLabel.vue";
import BaseTitle from "../components/BaseTitle.vue";
import BaseInput from "../components/BaseInput.vue";
import BaseButton from "../components/BaseButton.vue";
import BaseAlert from "../components/BaseAlert.vue";

export default {
	components: {
		BaseLabel,
		BaseInput,
		BaseButton,
		BaseTitle,
		BaseAlert
	},

	data() {
		return {
			user: {
				email: null,
				password: null
			},
			errorMessage: ""
		};
	},

	methods: {
		submitLogin() {
			this.$refs.loadingButton.startLoading();

			axios
				.post("/login", this.user)
				.then(response => {
					this.errorMessage = "";
					this.$refs.loadingButton.stopLoading();
					location.reload();
				})
				.catch(error => {
					this.$refs.loadingButton.stopLoading();
					console.log(error.response.data);
					// this.errorMessage = error.response.data.message;
					this.errorMessage = error.response.data.errors.email[0];
				});
		}
	}
};
</script>

<style scoped>
</style>