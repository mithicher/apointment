<template>
	<div>
		<modal name="hello-world" :adaptive="true" height="auto">
			<div class="p-8">
				<div class="flex mb-3 items-center">
					<div
						class="w-10 h-10 inline-flex items-center justify-center bg-blue-lightest rounded-full mr-4"
					>
						<Zondicon icon="notifications" class="fill-current text-blue text-xl svg-icon"></Zondicon>
					</div>
					<h2 class="text-xl md:text-2xl text-grey-darkest font-semibold">Confirm Appointment</h2>
				</div>

				<div class="border rounded-lg p-4 mb-2">
					<p class="mb-1 text-grey-darkest">{{ booking.shop_name }}</p>
					<p class="text-grey-darker text-sm font-semibold my-2">Hair Salon</p>
					<p class="text-grey-dark text-sm">{{ shop.shop_address }}</p>
				</div>
				<div class="border rounded-lg p-4 flex items-center">
					<p class="text-grey-darkest w-1/2">
						<Zondicon icon="calendar" class="fill-current text-grey svg-icon mr-2"></Zondicon>
						{{ booking.day }}
					</p>

					<p class="text-grey-darkest w-1/2">
						<Zondicon icon="time" class="fill-current text-grey svg-icon mr-2"></Zondicon>
						{{ booking.time }}
					</p>
				</div>

				<div class="mt-6 text-right">
					<base-button type="button" theme="grey-outline" :onClick="hide" class="mr-2">Cancel</base-button>
					<base-button
						ref="loadingButton"
						type="button"
						theme="blue"
						:onClick="processBooking"
					>Book Appointment</base-button>
				</div>
			</div>
		</modal>

		<div class="flex flex-wrap">
			<div class="w-full md:w-1/3">
				<h2 class="text-xl mb-1 text-grey-darkest">{{ shop.shop_name }}</h2>
				<p class="text-grey-darker text-sm font-semibold my-2">Hair Salon</p>
				<p class="text-grey-dark text-sm mb-5">{{ shop.shop_address }}</p>
			</div>
			<div class="w-full md:w-2/3">
				<div v-for="(bookingslot, index) in bookingslots" :key="index">
					<h2 class="text-xl mb-3 text-grey-darkest font-semibold">{{ index }}</h2>
					<p class="text-grey-dark text-xs uppercase tracking-wide font-semibold my-2">Choose a time</p>
					<span v-for="(bslot, index2) in bookingslot" :key="index2" class="inline-flex">
						<a
							v-popover:tooltip="'Available'"
							v-if="bslot.status == 'available'"
							@click.prevent="showModal(bslot)"
							href="#"
							class="mb-6 mr-4 inline-flex items-center justify-center rounded-lg border-2 border-blue text-blue hover:bg-blue hover:text-grey-lighter px-4 w-32 h-10 no-underline hover:bg-blue-dark font-semibold"
						>{{ bslot.time }}</a>
						
						<a
							v-popover:tooltip="'Booked'"
							v-if="bslot.status == 'booked'"
							href="#"
							class="mb-6 mr-4 inline-flex items-center justify-center rounded-lg bg-blue border-2 border-blue text-white hover:bg-blue-dark hover:border-blue-dark hover:text-grey-lighter px-4 w-32 h-10 no-underline hover:bg-blue-dark font-semibold opacity-75 cursor-not-allowed"
						>{{ bslot.time }}</a>
					</span>
				</div>
			</div>
		</div>

		<tooltip/>
	</div>
</template>

<script>
import "vue-js-modal/dist/styles.css";
import BaseButton from "../../components/BaseButton.vue";

export default {
	name: "BookingForm",
	props: {
		shop: {
			type: Object,
			required: true
		}
	},

	components: {
		BaseButton
	},

	data() {
		return {
			bookingslots: [],
			booking: {},
			shopData: this.shop
		};
	},

	mounted() {
		this.getTimeRange();
	},

	methods: {
		showModal(bslot) {
			this.booking = {
				time: bslot.time,
				day: bslot.date,
				shop_id: this.shop.id,
				shop_name: this.shop.shop_name,
				shop_address: this.shop.shop_address
			};

			this.$modal.show("hello-world", this.booking);
		},

		hide() {
			this.$modal.hide("hello-world");
		},

		getTimeRange() {
			axios
				.get(`/shops/${this.shopData.id}/bookingslots`)
				.then(response => {
					this.bookingslots = response.data;
				});
		},

		processBooking() {
			this.$refs.loadingButton.startLoading();
			axios
				.post(`/shops/${this.booking.shop_id}/booking`, this.booking)
				.then(response => {
					this.$refs.loadingButton.stopLoading();
					this.hide();
					location.replace(`/bookings/${response.data.data.id}`);
				})
				.catch(errors => {
					this.$refs.loadingButton.stopLoading();
				});
		}
	}
};
</script>

<style>
.v--modal {
	border-radius: 8px !important;
}
div[data-popover="tooltip"] {
	background: #444;
	color: #f9f9f9;
	font-family: inherit;
	font-size: 14px;
	line-height: 1.5;
	margin: 5px;
	padding-left: 10px;
	padding-right: 10px;
	width: auto !important;
}
</style>