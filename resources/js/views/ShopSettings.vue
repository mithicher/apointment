<template>
	<div>
		<div class="flex flex-wrap -mx-4">
			<div class="w-2/3 px-4">
				<div class="p-6 bg-white shadow rounded-lg mb-8">
					<base-title>Shop Settings</base-title>

					<form @submit.prevent="saveShop">
						<div class="mb-5">
							<base-label label="Name" hint="eg. ABC Beauty Specialist"></base-label>
							<base-input
								v-model="shop.shop_name"
								id="name"
								:error-feedback="(errors && errors.shop_name ? errors.shop_name : '')"
							></base-input>
						</div>

						<div class="mb-5">
							<base-label label="Phone Number"></base-label>
							<base-input
								v-model="shop.shop_phone"
								id="phone"
								:error-feedback="(errors.shop_phone ? errors.shop_phone : '')"
							></base-input>
						</div>

						<div class="mb-5">
							<base-label label="Address"></base-label>
							<base-input
								v-model="shop.shop_address"
								id="address"
								:error-feedback="(errors.shop_address ? errors.shop_address : '')"
							></base-input>
						</div>

						<div class="mt-4 flex justify-between">
							<base-button ref="loadingButton" type="submit" theme="blue">{{ saveButtonText }}</base-button>
							<base-button theme="red-light" v-if="shopId != null">Delete Shop?</base-button>
						</div>
					</form>
				</div>

				<appointment-settings></appointment-settings>
			</div>
			<div class="w-1/3 px-4">
				<div class="p-6 bg-white shadow rounded-lg mb-8" v-if="shopId != null">
					<div class="flex items-center">
						<base-title class>Status</base-title>
						<base-badge class="-mt-3 ml-3" :theme="shopStatus == true ? 'success': 'info'">
							<span v-if="shopStatus == true">Published</span>
							<span v-else>Draft</span>
						</base-badge>
					</div>

					<div class="flex justify-between items-center py-2">
						<div>Last Updated</div>
						<div>{{ shop.updated_at }}</div>
					</div>
					<div class="flex justify-between items-center py-2">
						<div>Update Status</div>
						<div>
							<base-switch color="#F5BF21" v-model="shopStatus" class="ml-2" @toggle="updateShopStatus"></base-switch>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import BaseLabel from "../components/BaseLabel.vue";
import BaseTitle from "../components/BaseTitle.vue";
import BaseSelect from "../components/BaseSelect.vue";
import BaseInput from "../components/BaseInput.vue";
import BaseButton from "../components/BaseButton.vue";
import BaseAlert from "../components/BaseAlert.vue";
import FormError from "../components/FormError.vue";
import BaseBadge from "../components/BaseBadge.vue";
import BaseSwitch from "../components/BaseSwitch.vue";
import AppointmentSettings from "../views/AppointmentSettings.vue";

export default {
	name: "shop-settings",
	components: {
		BaseLabel,
		BaseTitle,
		BaseSelect,
		BaseInput,
		BaseButton,
		BaseAlert,
		BaseBadge,
		BaseSwitch,
		FormError,
		AppointmentSettings
	},

	props: {
		// shops: {
		// 	type: Array,
		// 	required: true
		// }
	},

	mounted() {},

	data() {
		return {
			errors: {},
			shop: {
				shop_name: null,
				shop_phone: null,
				shop_address: null
			},
			shopId: null,
			statuses: {},
			shopStatus: false
		};
	},

	beforeRouteEnter(to, from, next) {
		axios.get("/shops").then(response => {
			next(vm => vm.setData(response.data));
		});
	},

	beforeRouteUpdate(to, from, next) {
		axios.get("/shops").then(response => {
			this.setData(response.data);
			next();
		});
	},

	methods: {
		setData(response) {
			if (response.data.length > 0) {
				this.shop = response.data[0];
				this.shopId = response.data[0].id;
				this.shopStatus = response.data[0].shop_isactive;
			}
		},

		saveShop() {
			if (this.shopId != null) {
				this.updateShop();
			} else {
				this.$refs.loadingButton.startLoading();
				axios
					.post("/shops", {
						shop_name: this.shop.shop_name,
						shop_phone: this.shop.shop_phone,
						shop_address: this.shop.shop_address
					})
					.then(response => {
						window.Fire.$emit("shopCreated", response.data.data.id);

						this.shop = response.data.data;
						this.shopId = response.data.data.id;

						this.errors = {};
						this.$refs.loadingButton.stopLoading();

						this.$snack.success({
							text: "Shop created successfully",
							button: "ok"
						});
					})
					.catch(error => {
						this.$refs.loadingButton.stopLoading();
						this.errors = error.response.data.errors;
					});
			}
		},

		updateShop() {
			this.$refs.loadingButton.startLoading();

			axios
				.put(`/shops/${this.shopId}`, {
					shop_name: this.shop.shop_name,
					shop_phone: this.shop.shop_phone,
					shop_address: this.shop.shop_address
				})
				.then(response => {
					this.shop = response.data.data;
					this.shopId = response.data.data.id;

					// this.buttonText = "Update Shop Settings";
					this.errors = {};
					this.$refs.loadingButton.stopLoading();

					this.$snack.success({
						text: "Shop updated successfully",
						button: "ok"
					});
				})
				.catch(error => {
					this.$refs.loadingButton.stopLoading();
					this.errors = error.response.data.errors;
				});
		},

		updateShopStatus() {
			axios
				.put(`/shops/${this.shopId}/status`, {
					shop_status: this.shopStatus
				})
				.then(response => {
					this.shopStatus = response.data.data.shop_isactive;
					this.errors = {};

					let statusText =
						response.data.data.shop_isactive == 0
							? "drafted"
							: "published";

					this.$snack.success({
						text: "Shop is " + statusText,
						button: "ok"
					});
				})
				.catch(error => {
					this.shopStatus = !this.shopStatus;
					this.$snack.danger({
						text: error.response.data.message,
						button: "ok"
					});
				});
		}
	},

	computed: {
		saveButtonText() {
			return this.shopId == null
				? "Save Shop Settings"
				: "Update Shop Settings";
		},

		getUser() {
			return window.Laravel.user;
		}
	}
};
</script>

<style scoped>
</style>