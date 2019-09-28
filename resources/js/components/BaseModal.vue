<template>
	<transition name="fade" mode="out-in">
		<div
			style="background-color: rgba(0, 0, 0, 0.5); z-index: 999;"
			class="w-full flex overflow-hidden fixed pin-x pin-y items-center justify-center"
		>
			<div
				:size="size"
				:class="modalSizeClass"
				class="block relative z-50 p-6 bg-white rounded-lg shadow-lg"
			>
				<!-- Confirm Modal Heading -->
				<div class="flex justify-between items-start mb-6" v-if="theme == 'confirm' || theme == 'info'">
					<!-- Confirm -->
					<div
						v-if="theme == 'confirm'"
						class="w-12 h-12 inline-flex items-center justify-center bg-red-lightest rounded-full"
					>
						<svg class="w-8 h-8 text-red" width="32" height="32" viewBox="0 0 24 24">
							<path
								fill="currentColor"
								d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z"
							></path>
						</svg>
					</div>
					<!-- Info -->
					<div
						v-if="theme == 'info'"
						class="w-12 h-12 inline-flex items-center justify-center bg-blue-lightest rounded-full"
					>
						<svg
							class="w-6 h-6 fill-current text-blue"
							xmlns="http://www.w3.org/2000/svg"
							viewBox="0 0 20 20"
						>
							<path
								d="M4 8a6 6 0 0 1 4.03-5.67 2 2 0 1 1 3.95 0A6 6 0 0 1 16 8v6l3 2v1H1v-1l3-2V8zm8 10a2 2 0 1 1-4 0h4z"
							></path>
						</svg>
					</div>
				</div>

				<slot name="modal-header"></slot>
				<slot name="modal-content"></slot>
				<slot name="modal-footer"></slot>

				<!-- Modal Close -->
				<button
					class="absolute pin-t pin-r mt-4 mr-4 rounded-full inline-flex items-center justify-center w-10 h-10 border-2 hover:border-blue trans-all-linear text-grey hover:text-blue outline-none"
					type="button"
					@click="closeModal"
				>
					<svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
						<path
							fill="currentColor"
							d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z"
						></path>
					</svg>
				</button>
			</div>
		</div>
	</transition>
</template>

<script>
export default {
	props: {
		url: [String],
		postData: [Object, Array],
		/**
		 * Sets the modal theme
		 * `confirm, info, modal`
		 */
		theme: {
			type: String,
			default: "confirm"
		},
		/**
		 * Sets the modal size
		 * `small, medium, large`
		 */
		size: {
			type: String,
			default: "small"
		}
	},
	created() {
		this.dataToSend = this.postData;
	},
	data() {
		return {
			dataToSend: null
			// showModal: false
		};
	},
	methods: {
		closeModal() {
			this.$emit("close");
		},
		// handleCloseButton() {
		// 	this.modalState = false;
		// 	window.eventBus.$emit("closed-modal-popup");
		// },
		// handleActionButton() {
		// 	this.modalState = true;
		// },
		handleConfirmButton() {
			this.$http.post(this.url, this.dataToSend).then(response => {
				this.$emit("onConfirm");
				this.closeModal();
			});
		}
	},
	computed: {
		modalSizeClass() {
			return {
				"max-w-sm w-full": this.size == "small",
				"max-w-md w-full": this.size == "medium",
				"max-w-lg w-full": this.size == "large"
			};
		}
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

.fade-enter-active,
.fade-leave-active {
	transition-duration: 0.3s;
	transition-property: opacity;
	transition-timing-function: ease;
}

.fade-enter,
.fade-leave-active {
	opacity: 0;
}
</style>