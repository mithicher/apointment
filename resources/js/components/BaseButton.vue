<template>
	<button @click="onClick" :type="type" :theme="theme" :class="buttonClass" :disabled="disabled">
		<!-- @slot Use this slot to place the button content -->
		<slot/>
	</button>
</template>

<script>
export default {
	name: "BaseButton",
	props: {
		/**
		 * Sets the button type
		 */
		type: {
			type: String,
			default: "button"
		},
		/**
		 * Sets the button theme
		 * `blue, blue-outline, blue-light`
		 * `red red-outline, red-light blue-link, red-link grey-outline`
		 */
		theme: {
			type: String,
			default: "blue",
			required: true
		},
		/**
		 * Gets called when the user clicks on the button
		 */
		onClick: {
			type: Function,
			// default: () => 1
			default: () => {
				return {};
			}
		},
		disabled: {
			type: Boolean,
			default: false
		},
		size: {
			type: String,
			default: "medium"
		}
	},

	data() {
		return {
			loading: false,
			disabledButton: this.disabled
		};
	},

	methods: {
		startLoading() {
			this.loading = true;
			this.disabledButton = true;
		},
		stopLoading() {
			this.loading = false;
			this.disabledButton = false;
		}
	},

	computed: {
		buttonClass() {
			return {
				"px-5 font-semibold rounded-lg outline-none trans-all-linear": true,
				"bg-blue hover:bg-blue-dark text-white": this.theme == "blue",
				"bg-transparent text-blue hover:text-blue-dark":
					this.theme == "blue-link",
				"bg-blue-lightest hover:bg-blue text-blue hover:text-white":
					this.theme == "blue-light",
				"bg-red hover:bg-red-dark text-white": this.theme == "red",
				"bg-transparent text-red hover:text-red-dark":
					this.theme == "red-link",
				"bg-red-lightest hover:bg-red text-red hover:text-white":
					this.theme == "red-light",
				"bg-transparent hover:bg-blue text-blue-dark hover:text-white border-2 border-blue hover:border-transparent":
					this.theme == "blue-outline",
				"bg-transparent hover:bg-red text-red-dark hover:text-white border-2 border-red-lighter hover:border-transparent":
					this.theme == "red-outline",
				"border-2 border-grey-light hover:bg-grey-light focus:bg-grey-light text-grey-dark":
					this.theme == "grey-outline",
				"opacity-50 cursor-not-allowed":
					this.disabled == true || this.disabledButton,
				"h-12": this.size == "large",
				"h-10": this.size == "medium",
				"base-spinner": this.loading
			};
		}
	}
};
</script>

<style scoped>
</style>