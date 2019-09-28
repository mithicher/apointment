<template>
	<div>
		<vue-ads-layout :full-bar="false">
			<vue-ads-bar slot="toolbar" :fixed="true" class="bg-white border-b border-grey-lighter px-4">
				<vue-ads-hide-button
					slot="first"
					:hidden="hiddenLeft"
					@clicked="hideLeft"
					class="cursor-pointer"
				>
					<span class="inline-flex items-center text-grey-darker hover:text-grey-darkest">
						<Zondicon icon="menu" class="fill-current mr-2 h-4 w-4"></Zondicon>Menu
					</span>
				</vue-ads-hide-button>
			</vue-ads-bar>

			<vue-ads-drawer
				slot="left-drawer"
				:fixed="true"
				:responsive="true"
				:hidden="hiddenLeft"
				:minified="minifiedLeft"
				@minify="minifyLeft"
				@hide="hideLeft"
				:minified-width="64"
				style="background-color: #334854"
			>
				<div slot="top">
					<a class="text-xl font-bold px-6 block py-4 no-underline text-white" href="/">ApointMe</a>

					<ul class="list-reset">
						<li class="px-6 py-2 mb-3 block text-grey no-underline text-truncate">Hello, {{ userName }}</li>
						<li v-for="(menuitem, index) in menuitems" :key="index">
							<router-link
								class="flex items-center px-6 py-3 block text-grey-light sidebar-link no-underline"
								:to="{name: menuitem.key}"
							>
								<Zondicon :icon="menuitem.icon" class="opacity-75 fill-current mr-6 svg-icon"></Zondicon>
								{{ menuitem.title }}
							</router-link>
						</li>
						<li
							class="font-semibold px-6 text-grey-dark text-xs uppercase tracking-wide mt-4 mb-2"
						>Admin Settings</li>
						<li v-for="(adminmenuitem, idx) in adminmenuitems" :key="adminmenuitem.key">
							<router-link
								class="flex items-center px-6 py-3 block text-grey-light sidebar-link no-underline"
								:to="{path: adminmenuitem.key}"
							>
								<Zondicon :icon="adminmenuitem.icon" class="opacity-75 fill-current mr-6 svg-icon"></Zondicon>
								{{ adminmenuitem.title }}
							</router-link>
						</li>
					</ul>
				</div>

				<div slot="bottom">
					<a
						class="flex items-center px-6 py-4 block text-grey-light sidebar-link no-underline"
						href="#"
						@click.prevent="logout"
					>
						<Zondicon icon="stand-by" class="opacity-75 fill-current mr-6 svg-icon"></Zondicon>Logout
					</a>
				</div>
			</vue-ads-drawer>
			<div class="mx-2 md:mx-8 md: my-6">
				<router-view></router-view>
			</div>
		</vue-ads-layout>
	</div>
</template>

<script>
// import "vue-ads-layout/dist/vue-ads-layout.css";
import {
	VueAdsLayout,
	VueAdsBar,
	VueAdsDrawer,
	VueAdsHideButton,
	VueAdsMinifyButton
} from "vue-ads-layout";

export default {
	props: {
		userId: {
			type: Number,
			required: true
		},
		userName: {
			type: String,
			required: true
		}
	},

	components: {
		VueAdsMinifyButton,
		VueAdsHideButton,
		VueAdsDrawer,
		VueAdsBar,
		VueAdsLayout
	},

	data() {
		return {
			minifiedLeft: null,
			minifiedRight: false,
			hiddenLeft: null,
			hiddenRight: false,

			menuitems: [
				{
					title: "Home",
					key: "dashboard",
					icon: "home"
				},
				{
					title: "Appointments",
					key: "appoinments",
					icon: "calendar"
				},
				{
					title: "Customers",
					key: "customers",
					icon: "user"
				},
				{
					title: "Reports",
					key: "reports",
					icon: "chart-pie"
				}
			],

			adminmenuitems: [
				{
					title: "Shops",
					key: "shops",
					icon: "store-front"
				},
				{
					title: "Business Hours",
					key: "businesshours",
					icon: "time"
				},
				{
					title: "Services",
					key: "services",
					icon: "cog"
				},
				{
					title: "Account & Settings",
					key: "settings",
					icon: "lock-closed"
				}
			]
		};
	},

	methods: {
		minifyLeft(minified) {
			this.minifiedLeft = minified;
		},

		hideLeft(hidden) {
			this.hiddenLeft = hidden;
		},

		logout() {
			axios.post("/logout").then(() => {
				window.location = "/";
			});
		}
	}
};
</script>

<style scoped>
.router-link-exact-active,
.sidebar-link:hover {
	color: #29a7c9;
}
</style>