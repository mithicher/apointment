<template>
	<div>
		<div class="bg-white shadow rounded-lg">
			<slot name="header"></slot>

			<div class="p-4 md:p-6">
				<slot name="body"></slot>
			</div>

			<slot name="footer"></slot>

			<slot></slot>
		</div>
	</div>
</template>

<script>
export default {
	name: "BaseCard"
};
</script>

<style scoped>
</style>