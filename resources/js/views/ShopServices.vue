<template>
	<div>
		<base-button type="button" theme="blue" class="mb-4" :onClick="showServiceModal">
			<Zondicon icon="add-outline" class="fill-current svg-icon mr-2"/>New Service
		</base-button>
		<base-button type="button" theme="grey-outline" class="mb-4 ml-2" :onClick="refreshPage">
			<Zondicon icon="refresh" class="fill-current svg-icon mr-2"/>Refresh Page
		</base-button>

		<base-modal size="medium" theme="modal" v-if="serviceModal" @close="showServiceModal">
			<div slot="modal-header">
				<base-title v-if="this.service.service_name == ''">Create New Service</base-title>
				<base-title v-else>Edit Service</base-title>
			</div>
			<div slot="modal-content" class="py-2">
				<base-alert class="mb-4" v-if="getShopId == null">
					<span slot="icon">
						<Zondicon icon="information-outline" class="fill-current mr-5 svg-icon"></Zondicon>
					</span>
					<span slot="content">Please create a shop first and then add appointment settings</span>
				</base-alert>

				<template v-if="getShopId != null">
					<div class="mb-5">
						<base-label label="Name" hint="eg. Haircut"></base-label>
						<base-input
							v-model="service.service_name"
							id="service_name"
							:error-feedback="(errors && errors.service_name ? errors.service_name : '')"
						></base-input>
					</div>

					<div class="mb-5">
						<base-label label="Details" hint="Brief description of your service"></base-label>
						<base-input
							v-model="service.service_details"
							id="service_details"
							:error-feedback="(errors && errors.service_details ? errors.service_details : '')"
						></base-input>
					</div>

					<div class="flex flex-wrap -mx-4">
						<div class="mb-5 w-1/3 px-4">
							<base-label label="Service Duration" hint="eg. 15 min or 1 hr"></base-label>
							<base-select class="mt-2" v-model="service.service_duration" :options="servicedurations"></base-select>
						</div>

						<div class="mb-5 w-1/3 px-4">
							<base-label label="Price" hint="Price with GST included"></base-label>
							<base-input
								v-model.number="service.service_price"
								id="service_price"
								:error-feedback="(errors && errors.service_price ? errors.service_price : '')"
							></base-input>
						</div>

						<div class="mb-5 w-1/3 px-4">
							<base-label label="Status" hint="Enable/Disable service" class="mb-2"></base-label>
							<base-switch color="#F5BF21" v-model="service.service_isactive" class="ml-2">
								<span v-if="service.service_isactive == true">Active</span>
								<span v-if="service.service_isactive == false">Not Active</span>
							</base-switch>
						</div>
					</div>
				</template>
			</div>

			<div v-if="getShopId != null" slot="modal-footer" class="flex justify-end text-right block pt-3">
				<base-button type="button" theme="grey-outline" class="mr-3" :onClick="showServiceModal">Cancel</base-button>

				<base-button
					ref="loadingButton"
					type="button"
					theme="blue"
					:onClick="saveServices"
					v-if="this.service.service_name == ''"
				>Save Service</base-button>

				<base-button
					v-else
					ref="loadingButton"
					type="button"
					theme="blue"
					:onClick="updateServices"
				>Update Service</base-button>
			</div>
		</base-modal>

		<base-card class="mb-5">
			<template slot="body">
				<base-title class="items-center">
					Shop Services
					<span
						slot="subtitle"
						class="text-sm text-grey-dark ml-2"
					>({{ this.servicesCount }})</span>
				</base-title>
				<vue-good-table
					mode="remote"
					:columns="columns"
					:rows="rows"
					:totalRows="totalRecords"
					:pagination-options="{
						enabled: true,
						perPage: 10,
						perPageDropdown: [10, 20, 30, 40, 50],
						dropdownAllowAll: false
					}"
					@on-page-change="onPageChange"
					@on-per-page-change="onPerPageChange"
					styleClass="vgt-table no-border"
				>
					<template slot="table-row" slot-scope="props">
						<span v-if="props.column.field == 'service_isactive'">
							<span v-if="props.row.service_isactive == true">
								<base-badge theme="success">Active</base-badge>
							</span>
							<span v-if="props.row.service_isactive == false">
								<base-badge theme="info">Not Active</base-badge>
							</span>
						</span>
						<span v-else>{{props.formattedRow[props.column.field]}}</span>
						
						<span v-if="props.column.field == 'action'">
							<a
								href="#"
								@click.prevent="showServiceModal(props.row)"
								class="text-blue hover:text-blue-dark text-uppercase text-xs tracking-wide no-underline uppercase font-semibold"
							>Edit</a>
						</span>
					</template>
				</vue-good-table>
			</template>
		</base-card>
	</div>
</template>

<script>
import BaseCard from "../components/BaseCard.vue";
import BaseTitle from "../components/BaseTitle.vue";
import BaseLabel from "../components/BaseLabel.vue";
import BaseInput from "../components/BaseInput.vue";
import BaseSelect from "../components/BaseSelect.vue";
import BaseButton from "../components/BaseButton.vue";
import BaseSwitch from "../components/BaseSwitch.vue";
import BaseAlert from "../components/BaseAlert.vue";
import BaseBadge from "../components/BaseBadge.vue";
import BaseModal from "../components/BaseModal.vue";

import { VueGoodTable } from "vue-good-table";
import "vue-good-table/dist/vue-good-table.css";
import { types } from "util";

export default {
	components: {
		BaseCard,
		BaseTitle,
		BaseLabel,
		BaseInput,
		BaseSelect,
		BaseButton,
		BaseSwitch,
		BaseAlert,
		BaseBadge,
		BaseModal,
		VueGoodTable
	},

	data() {
		return {
			serviceModal: false,
			servicedurations: {
				"10 min": 10,
				"15 min": 15,
				"30 min": 30,
				"45 min": 45,
				"1 hr": 60,
				"2 hr": 120
			},
			service: {
				service_name: "",
				service_details: "",
				service_duration: 15,
				service_isactive: false
			},
			serviceId: null,
			errors: {},
			shopId:
				window.Laravel.company.length > 0
					? window.Laravel.company[0].id
					: null,

			columns: [
				{
					label: "Name",
					field: "service_name",
					sortable: false
				},
				{
					label: "Detail",
					field: "service_details",
					sortable: false
				},
				{
					label: "Duration (in minutes)",
					field: "service_duration",
					sortable: false
				},
				{
					label: "Price (Rs.)",
					field: "service_price",
					type: "decimal",
					sortable: false
				},
				{
					label: "Status",
					field: "service_isactive",
					type: "boolean",
					sortable: false
				},
				{
					label: "Action",
					field: "action",
					width: "100px",
					thClass: "text-center",
					tdClass: "text-center",
					sortable: false
				}
			],
			rows: [],
			totalRecords: 0,
			serverParams: {
				// columnFilters: {},
				// sort: {
				// 	field: "",
				// 	type: ""
				// },
				page: 1,
				perPage: 10
			}
		};
	},

	computed: {
		getShopId() {
			// return window.Laravel.company.length > 0
			// 	? (this.shopId = window.Laravel.company[0].id)
			// 	: (this.shopId = null);
			return this.shopId;
		},

		servicesCount() {
			return this.rows.length;
		}
	},

	mounted() {
		// this.getShopId;
		window.Fire.$on("shopCreated", id => {
			this.shopId = id;
		});

		this.loadItems();
	},

	methods: {
		refreshPage() {
			location.reload();
		},

		showServiceModal(data) {
			this.serviceModal = !this.serviceModal;

			if (data.service_name != null) {
				this.service = data;
				this.serviceId = data.id;
			} else {
				this.service = {
					service_name: "",
					service_details: "",
					service_duration: 15,
					service_isactive: false
				};
			}
		},

		updateParams(newProps) {
			this.serverParams = Object.assign({}, this.serverParams, newProps);
		},

		onPageChange(params) {
			this.updateParams({ page: params.currentPage });
			this.loadItems();
		},

		onPerPageChange(params) {
			this.updateParams({ perPage: params.currentPerPage });
			this.loadItems();
		},

		loadItems() {
			axios
				.get(`/shops/${this.shopId}/services`, {
					params: this.serverParams
				})
				.then(response => {
					this.totalRecords = response.data.data.total;
					this.rows = response.data.data.data;
				});
		},

		saveServices() {
			this.$refs.loadingButton.startLoading();
			axios
				.post(`/shops/${this.shopId}/services`, this.service)
				.then(response => {
					console.log(response.data);
					this.errors = {};
					this.service.service_name = "";
					this.service.service_details = "";
					this.service.service_price = "";
					this.service.service_isactive = false;

					this.loadItems();
					this.serviceModal = false;

					this.$refs.loadingButton.stopLoading();

					this.$snack.success({
						text: "Shop service created successfully",
						button: "ok"
					});
				})
				.catch(error => {
					this.$refs.loadingButton.stopLoading();
					this.errors = error.response.data.errors;

					this.$snack.danger({
						text: error.response.data.message,
						button: "ok"
					});
				});
		},

		updateServices() {
			this.$refs.loadingButton.startLoading();
			axios
				.put(
					`/shops/${this.shopId}/services/${this.serviceId}`,
					this.service
				)
				.then(response => {
					this.errors = {};
					this.service.service_name = "";
					this.service.service_details = "";
					this.service.service_price = "";
					this.service.service_isactive = false;

					this.loadItems();
					this.serviceModal = false;

					this.$refs.loadingButton.stopLoading();

					this.$snack.success({
						text: "Shop service updated successfully",
						button: "ok"
					});
				})
				.catch(error => {
					this.$refs.loadingButton.stopLoading();
					this.errors = error.response.data.errors;

					this.$snack.danger({
						text: error.response.data.message,
						button: "ok"
					});
				});
		}
	}
};
</script>

<style>
table.vgt-table.no-border,
.vgt-wrap__actions-footer,
.vgt-wrap__footer {
	border: 0 !important;
}
.vgt-left-align.text-center {
	text-align: center !important;
}
</style>