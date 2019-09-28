<template>
	<div>
		<span
			class="inline-flex items-center text-xs uppercase tracking-wide font-bold px-3 py-1 rounded-full"
			theme="theme"
			:class="badgeClass"
		>
			<slot/>
		</span>
	</div>
</template>

<script>
export default {
	name: "BaseBadge",

	props: {
		theme: {
			type: String,
			default: "info"
		}
	},

	computed: {
		badgeClass() {
			return {
				"bg-green-lightest text-green-dark": this.theme === "success",
				"bg-blue-lightest text-blue-dark": this.theme === "info",
				"bg-red-lightest text-red-dark": this.theme === "danger"
			};
		}
	}
};
</script>

<style scoped>
</style>