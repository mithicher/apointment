<template>
	<div class="p-6 bg-white shadow rounded-lg mb-8">
		<base-title>Appointment Settings</base-title>

		<template v-if="shopId != null">
			<div class="mb-5">
				<base-label
					label="Default Appointment Time Slots"
					hint="The time slots step you define here will be applied for all time slots for appointment"
				></base-label>
				<base-select class="mt-2" v-model="appointmentslot" :options="appointmentslots"></base-select>
			</div>

			<div class="mb-5">
				<base-label
					label="Default Appointment Status"
					hint="All appointments will be scheduled with the status you choose here."
				></base-label>
				<base-select class="mt-2" v-model="appointmentstatus" :options="appointmentstatuses"></base-select>
			</div>

			<div class="mb-5">
				<base-label
					label="Period available for booking in advance"
					hint="Set how far a customer can book"
				></base-label>
				<base-select class="mt-2" v-model="bookingperiod" :options="bookingperiods"></base-select>
			</div>

			<div class="mt-4">
				<base-button
					ref="loadingButton"
					type="button"
					theme="blue"
					:onClick="updateAppointmentSettings"
				>Update Settings</base-button>
			</div>
		</template>

		<base-alert v-else theme="info">
			<span slot="icon">
				<Zondicon icon="information-outline" class="fill-current mr-5 svg-icon"></Zondicon>
			</span>
			<span slot="content">Please create a shop first and then add appointment settings</span>
		</base-alert>
	</div>
</template>

<script>
import BaseLabel from "../components/BaseLabel.vue";
import BaseTitle from "../components/BaseTitle.vue";
import BaseSelect from "../components/BaseSelect.vue";
import BaseInput from "../components/BaseInput.vue";
import BaseButton from "../components/BaseButton.vue";
import BaseAlert from "../components/BaseAlert.vue";

export default {
	name: "appointment-settings",

	components: {
		BaseLabel,
		BaseTitle,
		BaseSelect,
		BaseInput,
		BaseButton,
		BaseAlert
	},

	props: {
		statuses: [Object, Array]
		// shop: {
		// 	type: Number,
		// 	default: null
		// }
	},

	data() {
		return {
			appointmentstatuses: {},
			appointmentslots: {
				"10 min": 10,
				"15 min": 15,
				"20 min": 20,
				"30 min": 30
			},
			appointmentslot: 15,
			bookingperiods: { "7 days": 7, "14 days": 14 },
			bookingperiod: 7,
			appointmentstatus: 0,
			appointmentsettingId: null,
			shopId:
				window.Laravel.company.length > 0
					? window.Laravel.company[0].id
					: null
		};
	},

	mounted() {
		this.getAppointmentSettings();
		window.Fire.$on("shopCreated", id => {
			this.shopId = id;
			this.getAppointmentSettings();
		});

		this.getAppointmentStatuses();
	},

	methods: {
		getAppointmentStatuses() {
			axios.get("/appointmentstatuses").then(response => {
				this.appointmentstatuses = response.data;
			});
		},

		getAppointmentSettings() {
			axios
				.get(`/shops/${this.shopId}/appointment-settings`)
				.then(response => {
					console.log(response.data.data);
					this.appointmentslot = response.data.data.slot_range;
					this.bookingperiod = response.data.data.booking_period;
					this.appointmentsettingId = response.data.data.id;
				})
				.catch(error => {});
		},

		updateAppointmentSettings() {
			if (this.appointmentsettingId != null) {
				this.$refs.loadingButton.startLoading();

				axios
					.put(`/appointmentsettings/${this.appointmentsettingId}`, {
						slot_range: this.appointmentslot,
						booking_period: this.bookingperiod
					})
					.then(response => {
						this.appointmentslot = response.data.data.slot_range;
						this.bookingperiod = response.data.data.booking_period;
						this.appointmentsettingId = response.data.data.id;

						this.$refs.loadingButton.stopLoading();

						this.$snack.success({
							text: "Appointmentsettings updated successfully!",
							button: "ok"
						});
					})
					.catch(error => {
						this.$refs.loadingButton.stopLoading();
						this.$snack.danger({
							text: error.response.message,
							button: "ok"
						});
					});
			}

			return;
		}
	},

	computed: {}
};
</script>

<style scoped>
</style>