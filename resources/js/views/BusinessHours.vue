<template>
	<div class="p-6 bg-white shadow rounded-lg">
		<base-title>Business Hours & Days Off Settings</base-title>

		<div v-if="timings" v-for="(businesshour, index) in businessHours" :key="index">
			<div class="w-full mb-1 bg-blue-lightest text-blue rounded px-4 py-1">
				<Zondicon icon="calendar" class="svg-icon fill-current mr-1"/>
				{{ businesshour.dayName }}
			</div>
			<div class="flex flex-wrap w-full items-center -mx-4 mb-4">
				<div class="w-1/3 md:w-1/4 px-4">
					<div class="uppercase pt-1 mb-1 block px-4 text-xs tracking-wide text-grey">Status</div>
					<base-select v-model.number="businesshour.status" :options="statuses"></base-select>
				</div>
				<div class="w-1/3 md:w-1/4 px-4">
					<div class="uppercase px-4 mb-1 text-xs tracking-wide text-grey">Start Time</div>
					<vue-timepicker v-model="businesshour.open_time" hide-clear-button></vue-timepicker>
				</div>
				<div class="w-1/3 md:w-1/4 px-4">
					<div class="uppercase px-4 mb-1 text-xs tracking-wide text-grey">End Time</div>
					<vue-timepicker v-model="businesshour.close_time" hide-clear-button></vue-timepicker>
				</div>
			</div>
		</div>
		<div
			v-else
			v-for="(businesshour, idx) in businessHours"
			:key="idx"
			class="flex flex-wrap w-full items-center -mx-4"
		>
			<div
				class="w-full md:text-right px-4 mb-1 md:mb-0"
				v-model="businesshour.idx"
			>{{ businesshour.dayName }}</div>
			<div class="w-1/3 md:w-1/4 px-4">
				<base-select class="mt-2" v-model.number="businesshour.status" :options="statuses"></base-select>
			</div>
			<div class="w-1/3 md:w-1/4 px-4">
				<vue-timepicker v-model="businesshour.open_time" hide-clear-button></vue-timepicker>
			</div>
			<div class="w-1/3 md:w-1/4 px-4">
				<vue-timepicker v-model="businesshour.close_time" hide-clear-button></vue-timepicker>
			</div>
		</div>

		<div class="mt-4">
			<base-button type="button" theme="blue" :onClick="saveBusinessHours">Save Business Hours</base-button>
		</div>
	</div>
</template>

<script>
import VueTimepicker from "vue2-timepicker";
import BaseTitle from "../components/BaseTitle.vue";
import BaseSelect from "../components/BaseSelect.vue";
import BaseInput from "../components/BaseInput.vue";
import BaseButton from "../components/BaseButton.vue";

export default {
	// props: {
	// 	weekDays: [Object, Array]
	// },

	components: {
		VueTimepicker,
		BaseTitle,
		BaseSelect,
		BaseInput,
		BaseButton
	},

	data() {
		return {
			statuses: {
				open: "open",
				closed: "closed"
			},
			timings: [],
			weekdays: []
		};
	},

	beforeRouteEnter(to, from, next) {
		axios.get("/businesshours").then(response => {
			next(vm => vm.setData(response.data));
		});
	},

	beforeRouteUpdate(to, from, next) {
		axios.get("/businesshours").then(response => {
			this.setData(response.data);
			next();
		});
	},

	methods: {
		setData(response) {
			this.timings = response;
		},

		saveBusinessHours() {
			console.log(this.businessHours);
			axios
				.post("/hours", { hours: JSON.stringify(this.businessHours) })
				.then(response => {
					console.log(response);
				})
				.catch(error => {
					console.log(error);
				});
		},

		// getBusinessHours() {
		// 	axios.get("/businesshours").then(response => {
		// 		this.timings = response.data;
		// 	});
		// },

		getWeekDays() {
			axios.get("/weekdays").then(response => {
				this.weekdays = response.data;
			});
		}
	},

	mounted() {
		// this.getBusinessHours();
		this.getWeekDays();
	},

	computed: {
		businessHours() {
			if (this.timings.length > 0) {
				return this.timings.map((timing, index) => {
					return {
						dayOfWeek: timing.day_of_week,
						dayName: this.weekdays[timing.day_of_week],
						status: timing.status,
						open_time: {
							HH: timing.open_time.HH,
							mm: timing.open_time.mm
						},
						close_time: {
							HH: timing.close_time.HH,
							mm: timing.close_time.mm
						}
					};
				});
			} else {
				return this.weekdays.map((item, index) => {
					return {
						dayOfWeek: index,
						dayName: item,
						status: "open",
						open_time: {
							HH: "00",
							mm: "00"
						},
						close_time: {
							HH: "00",
							mm: "00"
						}
					};
				});
			}
		}
	}
};
</script>

<style>
.time-picker input.display-time {
	border: 2px solid #dae1e7;
	width: 10em;
	/* height: 3em; */
	height: 2.5em;
	padding: 0 1em;
	font-size: 1em;
	border-radius: 0.5em;
	outline: none;
}
.time-picker input.display-time:focus {
	border-color: #d2d2d2;
}

.time-picker .dropdown {
	top: calc(2.5em + 2px);
	font-family: inherit;
	border-radius: 0.5em;
}

.time-picker .dropdown ul li.active,
.time-picker .dropdown ul li.active:hover {
	background: #f8f8f8;
	color: #41b883;
}
</style>