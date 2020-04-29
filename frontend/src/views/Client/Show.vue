<template lang="pug">
  div
    widget
      b-row
        b-col(md="6")
          h4 {{ 'Страница клиента' }}
        b-col.text-right(md="6")
          router-link.btn.btn-primary(:to="{name:'clients'}") {{ 'Назад' }}
      hr
      b-row
        b-col(md="6")
          p {{ this.currentClient ? this.currentClient.name: '' }}
          p {{ this.currentClient ? this.currentClient.email: '' }}
          p {{ this.currentClient? this.currentClient.phone: '' }}
      hr
      b-form.form-label-left.mt-4
        b-alert.alert-sm(variant='danger', :show='isError')
          | {{ errorMessage }}
      .contacts-table
        Loader(:show="isLoaded", :is-custom="true")
        TableComponent.mt-5.mb-4(
          :columns="columns"
          :values="history"
          type="stripped"
          :pagination="false"
        )
          template(v-slot:date="{value}")
            div(v-if="value.date")
              | {{ $moment(value.date, 'YYYY-MM-DD HH:mm:ss ZZ').format('Do MMMM YYYY, HH:mm:ss') }}


</template>

<script>
	import {mapActions, mapGetters} from 'vuex';
	import Widget from '../../components/Widget/Widget';
	import Loader from '../../components/Loader/Loader';
	import TableComponent from '../../components/Table/Table';
	import PaginationMixin from '../../components/mixins/pagination';

	export default {
		name: "Client",
		mixins: [PaginationMixin],
		components: {
			Widget,
			Loader,
			TableComponent,
		},
		data() {
			return {
				clientId: '',
				page: 1,
				perPage: 20,
				columns: [
					{name: 'date', title: 'Дата изменения'},
					{name: 'type', title: 'Тип'},
					{name: 'name', title: 'Поле'},
					{name: 'old', title: 'Было'},
					{name: 'new', title: 'Стало'},
				],
			}
		},
		computed: {
			...mapGetters('client', ['clients', 'currentClient', 'history', 'isLoading']),
			isLoaded() {
				return this.isLoading;
			},

			isError() {
			},
			errorMessage() {
			},
		},

		created() {
			// this.$set(this, 'clientId', this.client);
		},

		mounted() {
			this.clientId = this.$route.params.id;
			this.getList();
		},
		methods: {
			...mapActions('client', {
				'showClient': 'show',
			}),
			getList() {
				this.showClient(this.clientId)
			},
		},
	}
</script>
