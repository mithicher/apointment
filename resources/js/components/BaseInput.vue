<template>
	<div>
		<input
			:type="type"
			:value="value"
			@input="updateInput($event.target.value)"
			:placeholder="placeholder"
			:class="inputClass"
			:required="required"
			:disabled="disabled"
		>
		
		<span
			class="block my-2 w-full text-sm text-red"
			v-if="errorFeedback != undefined || errorFeedback.length > 0"
		>{{ errorFeedback[0] }}</span>
	</div>
</template>

<script>
export default {
	name: "FormInput",
	props: {
		id: {
			type: String,
			required: true
		},
		type: {
			type: String,
			default: "text"
		},
		value: [String, Number],
		required: {
			type: Boolean,
			default: false
		},
		placeholder: {
			type: String,
			default: null
		},
		size: {
			type: String,
			default: "medium"
		},
		disabled: {
			type: Boolean,
			default: false
		},
		errorFeedback: [String, Object, Array, Boolean]
	},
	methods: {
		updateInput(value) {
			this.$emit("input", value);
		}
	},
	computed: {
		inputClass() {
			return {
				"block w-full outline-none px-3 border-2 focus:border-blue rounded-lg": true,
				"border-red":
					(this.errorFeedback != "" &&
						this.errorFeedback.length > 0) ||
					this.errorFeedback == true,
				"h-12": this.size == "large",
				"h-10": this.size == "medium",
				"opacity-50 cursor-not-allowed": this.disabled == true
			};
		}
	}
};
</script>

<style scoped>
</style>