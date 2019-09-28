<template>
	<div class="border-l-4 rounded-lg p-4" :class="alertClass" :theme="theme">
		<div class="flex w-full">
			<slot class="text-center mr-4" name="icon"></slot>
			<slot name="content"></slot>
		</div>
	</div>
</template>

<script>
export default {
	name: "BaseAlert",
	props: {
		/**
		 * Sets the button theme
		 * `info, danger`
		 */
		theme: {
			type: String,
			default: "info"
		}
	},
	computed: {
		alertClass() {
			return {
				"bg-blue-lightest text-blue border-blue": this.theme == "info",
				"bg-red-lightest text-red border-red": this.theme == "danger"
			};
		}
	}
};
</script>

<style scoped>
</style>