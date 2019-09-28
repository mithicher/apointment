<template>
	<div>
		<base-card>
			<template slot="body">
				<div class="flex">
					<img :src="calendarImg" alt="calendar-image" class="h-24 mr-5">
					<div>
						<base-title>Welcome Back!</base-title>
						<p
							class="text-grey-dark leading-normal"
						>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Saepe commodi maiores corrupti? Quos et esse fuga quasi quam ipsum numquam perferendis expedita laudantium, sunt eligendi inventore tempora dignissimos sequi qui?</p>
					</div>
				</div>
			</template>
		</base-card>
	</div>
</template>

<script>
import BaseCard from "../components/BaseCard.vue";
import BaseTitle from "../components/BaseTitle.vue";
import BaseAlert from "../components/BaseAlert.vue";

export default {
	name: "Dashboard",

	components: {
		BaseCard,
		BaseTitle,
		BaseAlert
	},

	data() {
		return {
			calendarImg: "/svg/calendar.svg"
		};
	}
};
</script>

<style scoped>
</style>