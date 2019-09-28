<template>
	<div>
		<div class="w-full md:max-w-xl mx-auto py-10 md:py-16">
			<div
				class="bg-white shadow rounded-lg p-6 lg:p-10 flex flex-wrap w-full justify-center relative"
			>
				<div class="w-full md:w-1/2 md:pr-6">
					<base-title class="text-center md:text-2xl lg:text-3xl">Create an account. It's Free</base-title>
					<p class="-mt-1 mb-5 text-grey-darkest">
						Already have an account?
						<a
							href="/login"
							class="no-underline text-blue hover:text-blue-dark"
						>Login to continue</a>
					</p>

					<!-- <base-alert class="mb-4" v-if="errorMessage" theme="danger">
						<span slot="icon">
							<Zondicon icon="information-outline" class="fill-current mr-4 svg-icon"></Zondicon>
						</span>
						<span slot="content">{{ errorMessage }}</span>
					</base-alert>-->
					<form @submit.prevent="submitRegisterForm">
						<div class="mb-5">
							<base-label label="Name"></base-label>
							<base-input
								type="text"
								v-model="user.name"
								id="email"
								name="email"
								size="large"
								required
								placeholder="eg. John Rambo"
								:error-feedback="(errors && errors.name ? errors.name : '')"
							></base-input>
						</div>

						<div class="mb-5">
							<base-label label="Email"></base-label>
							<base-input
								type="email"
								v-model="user.email"
								id="email"
								name="email"
								size="large"
								required
								placeholder="eg. hello@example.com"
								:error-feedback="(errors && errors.email ? errors.email : '')"
							></base-input>
						</div>

						<div class="mb-5">
							<base-label label="Password"></base-label>
							<base-input
								type="password"
								v-model="user.password"
								id="password"
								name="password"
								required
								size="large"
								placeholder="Must be at least 6 characters"
								:error-feedback="(errors && errors.password ? errors.password : '')"
							></base-input>
						</div>

						<div class="mb-5">
							<base-label label="Confirm Password"></base-label>
							<base-input
								type="password"
								v-model="user.password_confirmation"
								id="password"
								name="password"
								required
								size="large"
								placeholder="Must be at least 6 characters"
								:error-feedback="(errors && errors.password_confirmation ? errors.password_confirmation : '')"
							></base-input>
						</div>

						<base-button
							ref="loadingButton"
							type="submit"
							theme="blue"
							size="large"
							class="mt-2 w-full rounded-lg"
						>Let's get started</base-button>
					</form>

					<div class="px-4 py-3 bg-blue-lightest rounded-lg mt-6">
						<p class="mb-0 text-grey-darkest leading-normal">
							By creating an account you agree to Apoint's
							<a
								href="#"
								class="no-underline text-blue hover:text-blue-dark"
							>Terms of Service</a> and
							<a href="#" class="no-underline text-blue hover:text-blue-dark">Privacy Policy</a>.
						</p>
					</div>
				</div>
				<div class="w-full md:w-1/2 text-center">
					<div class="mb-5 pt-5 md:pt-24 md:w-3/4 mx-auto text-left">
						<p class="text-grey-dark mb-4 font-semibold text-lg">What you will get!</p>
						<div class="flex items-center mb-4">
							<span class="inline-flex bg-blue-lightest rounded-full mr-4 p-1">
								<Zondicon icon="checkmark" class="fill-current text-xs text-blue-light svg-icon"></Zondicon>
							</span>
							<span class="text-grey-darker">Can book an appointment</span>
						</div>
						<div class="flex items-center mb-4">
							<span class="inline-flex bg-blue-lightest rounded-full mr-4 p-1">
								<Zondicon icon="checkmark" class="fill-current text-xs text-blue-light svg-icon"></Zondicon>
							</span>
							<span class="text-grey-darker">Recieve Email and SMS Notifications</span>
						</div>
						<div class="flex items-center mb-4">
							<span class="inline-flex bg-blue-lightest rounded-full mr-4 p-1">
								<Zondicon icon="checkmark" class="fill-current text-xs text-blue-light svg-icon"></Zondicon>
							</span>
							<span class="text-grey-darker">Sync appointments with Google Calendar</span>
						</div>
						<div class="flex items-center mb-4">
							<span class="inline-flex bg-blue-lightest rounded-full mr-4 p-1">
								<Zondicon icon="checkmark" class="fill-current text-xs text-blue-light svg-icon"></Zondicon>
							</span>
							<span class="text-grey-darker">Get Discount Coupons</span>
						</div>
						<div class="flex items-center mb-4">
							<span class="inline-flex bg-blue-lightest rounded-full mr-4 p-1">
								<Zondicon icon="checkmark" class="fill-current text-xs text-blue-light svg-icon"></Zondicon>
							</span>
							<span class="text-grey-darker">Get SMS alerts before appointment date</span>
						</div>
					</div>
					<img src="/svg/booking.svg" alt="illustration" class="h-64 md:absolute pin-b pin-r mb-6 mr-6">
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
				name: null,
				email: null,
				password: null,
				password_confirmation: null
			},
			errorMessage: "",
			errors: {}
		};
	},

	methods: {
		submitRegisterForm() {
			this.$refs.loadingButton.startLoading();

			axios
				.post("/register", this.user)
				.then(response => {
					this.errorMessage = "";
					this.$refs.loadingButton.stopLoading();
					location.replace("/login");
				})
				.catch(error => {
					this.$refs.loadingButton.stopLoading();
					this.errors = error.response.data.errors;
					console.log(error.response.data);
					// this.errorMessage = error.response.data.message;
				});
		}
	}
};
</script>

<style scoped>
</style>