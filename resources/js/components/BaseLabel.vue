<template>
	<div>
		<label class="block mb-2 text-grey-darker font-semibold" v-text="label"></label>
		<span class="block my-2 w-full text-sm text-grey-dark" v-html="hint"></span>
	</div>
</template>

<script>
export default {
	name: "BaseLabel",
	props: {
		hint: {
			type: String,
			default: null
		},
		label: {
			type: String,
			default: "Your label"
		}
	}
};
</script>

<style scoped>
</style>