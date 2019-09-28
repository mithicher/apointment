<template>
	<div
		class="relative w-48 bg-white rounded border border-green cursor-pointer focus:outline-none focus:shadow-outline-green h-24"
		tabindex="0"
		@click="updateActivePlan"
		@keydown.space="updateActivePlan"
	>
		<div class="flex flex-col items-center w-full p-4">
			<p class="text-base tracking-wide text-green" :class="{'mb-2' : hasDescSlot}">{{ this.label }}</p>
			<slot class="flex-1 text-grey-darker" name="desc"></slot>
		</div>
		<div
			v-if="this.activePlan === this.label"
			class="px-1 float-right -mr-3 rounded-full bg-white p-1 absolute pin-b pin-r -mb-3"
			style="width:1.7rem;height:1.7rem;"
		>
			<svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
				<path
					d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM6.7 9.29L9 11.6l4.3-4.3 1.4 1.42L9 14.4l-3.7-3.7 1.4-1.42z"
					fill="#38c172"
				></path>
			</svg>
		</div>
	</div>
	<!-- <div>
        <input type="hidden" :value="value">
        <input type="checkbox" :value="value">
        <label>{{label}}</label>
	</div>-->
</template>

<script>
export default {
	model: {
		prop: "activePlan",
		event: "onUpdatePlan"
	},

	props: {
		label: {
			type: String
		},
		activePlan: {
			type: String
		}
	},

	computed: {
		hasDescSlot() {
			return !!this.$slots["desc"];
		}
	},

	methods: {
		updateActivePlan() {
			this.$emit("onUpdatePlan", this.label);
		}
	}
};
</script>

<style scoped>
/* .svg_icon {
    transition: 2s;
} */
.icon_set:before {
	width: 100px;
	left: -100px;
}
.icon_set:after {
	height: 100px;
	top: -100px;
}
.icon_set:before {
	content: "";
	position: absolute;
	height: 2px;
	background: #000;
	top: 50%;
}
.icon_set:after {
	content: "";
	position: absolute;
	width: 2px;
	background: #000;
	left: 50%;
}
</style>