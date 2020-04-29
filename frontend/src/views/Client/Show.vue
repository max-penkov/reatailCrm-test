<template>
	<div class="profile">
		<b-button @click="goBack">
			Назад
		</b-button>
	</div>
</template>

<script>
	export default {
		name: "Client",
		data() {
			return {}
		},
		methods: {
			goBack() {
				this.$router.go(-1)
			}
		}
	}
</script>
