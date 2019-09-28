<template>
	<span class="block my-2 w-full text-sm text-red">
		<slot></slot>
	</span>
	<!-- <form-error v-if="errors.shop_name" :errors="errors">{{ errors.shop_name[0] }}</form-error> -->
</template>

<script>
export default {
	props: ["errors"]
};
</script>