<template>
	<div class="relative inline-block">
		<div
			role="button"
			class="inline-block select-none cursor-pointer"
			@click.prevent="showDropDown = !showDropDown"
		>
			<div class="flex items-center">
				<span class="mr-1">
					<slot name="dropdown-title"></slot>
				</span>
				<span v-if="icon">
					<svg
						v-if="showDropDown"
						class="inline-block fill-current text-grey h-5"
						xmlns="http://www.w3.org/2000/svg"
						viewBox="0 0 20 20"
					>
						<path d="M10.707 7.05L10 6.343 4.343 12l1.414 1.414L10 9.172l4.243 4.242L15.657 12z"></path>
					</svg>
					<svg
						v-else
						class="inline-block fill-current text-grey h-5"
						xmlns="http://www.w3.org/2000/svg"
						viewBox="0 0 20 20"
					>
						<path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"></path>
					</svg>
				</span>
			</div>
		</div>
		<transition name="slide-fade">
			<div class="absolute pin-r w-48 mt-2 z-20" v-show="showDropDown">
				<slot name="dropdown-items"></slot>
			</div>
		</transition>
		<div v-if="showDropDown" @click="showDropDown = !showDropDown" class="fixed pin-x pin-y z-10"></div>
	</div>
</template>

<script>
export default {
	name: "BaseDropdown",
	props: {
		// label: {
		// 	type: String,
		// 	default: "Dropdown Label",
		// 	required: true
		// },
		icon: {
			type: Boolean,
			default: true
		}
	},
	data() {
		return {
			showDropDown: false
		};
	}
};
</script>

<style scoped>
.slide-fade-enter-active {
	transition: all 0.3s ease;
}
.slide-fade-leave-active {
	transition: all 0.2s ease;
}
.slide-fade-enter {
	transform: translateY(-20px);
	opacity: 0;
}
.slide-fade-leave-to {
	transform: translateY(-20px);
	opacity: 0;
}
</style>