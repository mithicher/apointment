<template>
	<div>
		<base-dropdown>
			<span
				slot="dropdown-title"
				class="shadow-inner inline-flex items-center justify-center w-8 h-8 text-center rounded-full bg-blue-lightest text-blue-dark text-sm"
			>{{ dropdownLabel }}</span>
			<div
				slot="dropdown-items"
				class="border-t border-grey-lighter bg-white rounded-lg shadow-md py-1"
			>
				<div
					class="border-b border-grey-lighter px-4 py-2 truncate mb-1 text-grey-dark font-semibold"
				>Hi, {{ title }}</div>
				<a
					href="#"
					class="block px-4 py-2 no-underline text-grey-dark hover:bg-blue-lightest hover:text-blue"
				>My Account</a>
				<a
					href="#"
					class="block px-4 py-2 no-underline text-grey-dark hover:bg-blue-lightest hover:text-blue"
				>My Appointments</a>

				<div class="border-b border-t border-grey-lighter my-1 py-1">
					<a
						href="#"
						class="block px-4 py-2 no-underline text-grey-dark hover:bg-blue-lightest hover:text-blue"
					>Notifications</a>
					<a
						href="#"
						class="block px-4 py-2 no-underline text-grey-dark hover:bg-blue-lightest hover:text-blue"
					>Settings</a>
				</div>
				<a
					href="#"
					@click.prevent="logout()"
					class="block px-4 py-2 no-underline text-grey-dark hover:bg-blue-lightest hover:text-blue"
				>Logout</a>
			</div>
		</base-dropdown>
	</div>
</template>

<script>
import BaseDropdown from "../components/BaseDropdown.vue";

export default {
	name: "NavbarDropdown",

	props: {
		title: {
			type: String,
			required: true
		}
	},

	components: {
		BaseDropdown
	},

	data() {
		return {
			dropdownLabel: ""
		};
	},

	mounted() {
		this.getFirstTwoLettersFromName();
	},

	methods: {
		logout() {
			axios.post("/logout").then(() => {
				window.location = "/";
			});
		},

		getFirstTwoLettersFromName() {
			let strArray = this.title.split(" ");
			let newName = strArray[0].charAt(0) + strArray[1].charAt(0);

			this.dropdownLabel = newName;
		}
	}
};
</script>

<style scoped>
</style>