<template>
	<div>
		<div class="flex flex-wrap">
			<div class="w-full md:w-2/3">
				<div v-for="(appointmentdatas, index) in appointments" :key="index">
					<div class="bg-white rounded-lg shadow mb-4">
						<div class="bg-grey-lighter rounded-t-lg px-4 py-3">
							<div class="font-semibold">{{ index | moment("dddd, MMMM DD, YYYY") }}</div>
						</div>

						<div
							v-for="(appointmentdata, idx) in appointmentdatas"
							:key="idx"
							class="px-4 py-5 flex flex-wrap w-full border-t border-grey-lighter"
						>
							<div class="w-1/4">
								<p class="mb-2 md:mb-0 text-grey-dark inline-flex items-center">
									<Zondicon icon="time" class="fill-current svg-icon mr-1"></Zondicon>
									{{ appointmentdata.start_time | formatTime }}
								</p>
							</div>
							<div class="w-3/4">
								<p
									class="font-semibold mb-2 text-grey-darkest"
								>{{ appointmentdata.user.shops[0].shop_name }}</p>
								<p
									class="text-grey-dark leading-normal text-sm"
								>{{ appointmentdata.user.shops[0].shop_address }}</p>
								<p
									class="text-grey-dark leading-normal text-sm"
								>{{ appointmentdata.user.shops[0].shop_phone }}</p>

								<div class="flex flex-wrap justify-between mt-4">
									<p>
										<!-- <span
											class="px-3 py-1 inline-block text-xs tracking-wide font-semibold uppercase rounded-full bg-orange-lightest text-orange"
										>Pending</span>-->
										<span
											class="px-3 py-1 inline-block text-xs tracking-wide font-semibold uppercase rounded-full bg-green-lightest text-green"
										>Completed</span>
									</p>
									<p class="mb-0">
										<a href="#" class="no-underline inline-flex items-center text-blue hover:text-blue-dark">
											<Zondicon icon="add-outline" class="fill-current text-blue svg-icon mr-1"></Zondicon>Add review
										</a>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="w-full md:w-1/3 text-center">
				<div class="md:px-6">
					<v-calendar
						:attributes="attributes"
						is-expanded
						nav-visibility="hidden"
						:theme-styles="themeStyles"
					>
						<div
							slot="day-popover-header"
							slot-scope="{ day }"
							class="border-b p-1 mb-2"
						>{{ getPopoverHeaderLabel(day) }}</div>
						<div slot="date-row" slot-scope="{ customData }">
							<div class="todo-content" v-for="detail in customData">
								<p>{{ detail.shop_name }} ({{ detail.time }})</p>
							</div>
						</div>
					</v-calendar>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import { setupCalendar, Calendar } from "v-calendar";
import "v-calendar/lib/v-calendar.min.css";

export default {
	name: "Appointments",
	components: { "v-calendar": Calendar },

	props: {
		appointments: {
			type: [Array, Object],
			required: true
		},
		calendardata: [Array, Object]
	},

	mounted() {
		console.log(this.calendardata);
	},

	data() {
		return {
			newappointments: this.appointments,
			attrs: [
				{
					key: "today",
					highlight: {
						backgroundColor: "#29a7c9"
						// Other properties are available too, like `height` & `borderRadius`
					},
					contentStyle: {
						color: "#fafafa"
					},
					dates: new Date(),

					popover: {
						label: "You just hovered over today's date!"
					}
				},
				{
					dot: {
						backgroundColor: "#ff4d4d" // Red dot
					},
					dates: [
						new Date(2019, 0, 1), // Jan 1st
						new Date(2019, 0, 10), // Jan 10th
						new Date(2019, 0, 17), // Jan 17th
						new Date(2019, 0, 22) // Jan 22nd
					]
				}
			],

			themeStyles: {
				wrapper: {
					background: "transparent"
					// borderRadius: "8px",
					// boxShadow: "0 1px 2px 0 rgba(0, 0, 0, 0.14)"
				},
				header: {
					// padding: "20px 0"
				},
				// headerHorizontalDivider: {
				// 	borderTop: "solid rgba(0, 0, 0, 0.05) 1px",
				// 	width: "80%"
				// }
				weekdays: {
					fontWeight: "700" // And bolder font weight
				},
				dayCellNotInMonth: {
					opacity: 0
				}
				// dots: {
				// 	marginBottom: "10px"
				// }
			}
		};
	},

	methods: {
		getPopoverHeaderLabel(day) {
			const options = {
				weekday: "short",
				year: "numeric",
				month: "short",
				day: "numeric"
			};
			return day.date.toLocaleDateString(
				window.navigator.userLanguage || window.navigator.language,
				options
			);
		}
	},

	computed: {
		attributes() {
			return [
				// Today attribute
				{
					contentStyle: {
						fontWeight: "700",
						fontSize: ".9rem"
					},
					dates: new Date(),
					key: "today",
					highlight: {
						backgroundColor: "#29a7c9"
						// Other properties are available too, like `height` & `borderRadius`
					},
					contentStyle: {
						color: "#fafafa"
					}
				},
				// Attributes for todos
				...this.calendardata.map((data, index) => ({
					dates: new Date(data.year, data.month, data.date),
					dot: {
						backgroundColor: "#ff4d4d",
						opacity: 1
					},
					customData: data.details,
					// popover: {
					// 	label: "hello " + index
					// },
					popover: {
						hideIndicator: true,
						slot: "date-row" // Matches slot from above
						// visibility: "focus"
					}
				}))
			];
		}
	}
};
</script>


<style>
.c-arrow-layout {
	display: none !important;
}
</style>
