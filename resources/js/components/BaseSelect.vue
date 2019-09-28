<template>
	<div>
		<select
			v-model="selectedOption"
			@input="event => { $emit('input', event.target.value) }"
			:required="required"
			class="block bg-transparent w-full outline-none border-0 select-css"
			:class="selectClass"
			size="size"
		>
			<option v-for="(option, name) in options" :value="option" :key="name">{{ name }}</option>
		</select>
		
		<span
			class="block my-2 w-full text-sm text-red"
			v-if="errorFeedback != undefined || errorFeedback.length > 0"
		>{{ errorFeedback[0] }}</span>
	</div>
</template>

<script>
export default {
	name: "BaseSelect",
	props: {
		value: null,
		options: [Object, Array],
		required: {
			type: Boolean,
			default: false
		},
		errorFeedback: [String, Object, Array, Boolean],
		size: {
			type: String,
			default: "medium"
		}
	},
	data() {
		return {
			selectedOption: null
		};
	},
	mounted() {
		this.selectedOption = this.value;
	},
	watch: {
		value: function(newValue) {
			this.selectedOption = newValue;
		}
	},
	computed: {
		selectClass() {
			return {
				"block bg-white w-full outline-none px-2 border-2 focus:border-blue rounded-lg": true,
				"border-red":
					(this.errorFeedback != "" &&
						this.errorFeedback.length > 0) ||
					this.errorFeedback == true,
				"h-12": this.size == "large",
				"h-10": this.size == "medium"
			};
		}
	}
};
</script>

<style scoped>
.select-css {
	margin: 0;
	padding-left: 0.8em;
	-moz-appearance: none;
	-webkit-appearance: none;
	appearance: none;
	background-color: #fff;
	/* background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23007CB2%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E"),
		linear-gradient(to bottom, #ffffff 0%, #ffffff 100%); */

	background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3E%3Cpath fill='%23aaaaaa' d='M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z'/%3E%3C/svg%3E");
	background-repeat: no-repeat, repeat;
	background-position: right 0.7em top 50%, 0 0;
	background-size: 1.2em auto, 100%;
}
.select-css::-ms-expand {
	display: none;
}
</style>