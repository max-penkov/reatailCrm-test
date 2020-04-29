<template lang="pug">
  .clients-page
    router-view
    b-row
      b-col(lg="6")
        Loader(:show="isLoaded", :is-custom="true")
        Widget(
          title="<h4>Клиенты</h4>"
          customHeader
        )
          b-alert.alert-sm(variant='danger', :show='isError')
            | {{ errorMessage }}
          TableComponent(
            :columns="columns"
            :values="clients"
            :search="true"
            @page-change="changePage",
            :pagination="true",
            :pageCount="pageCount"
            type="stripped"
          )
            template(v-slot:actions="{value}")
              .btn.btn-sm.btn-info.mr-xs(
                @click="editClient(value.id)"
                title="Редактирование"
              )
                i.fa.fa-pencil
              .btn.btn-sm.btn-danger.mr-xs(
                @click="showClient(value.id)"
                title="Посмотреть"
              )
                i.fa.fa-eye

      b-col(lg="6")
        ClientForm(
          :is-edit="isEdit",
          :client-id="clientId"
          @cancelEdit="cancelEdit"
        )
</template>
<script>
	import Footer from '../../components/Parts/Footer';
	import ClientForm from './components/Form';
	import Loader from '../../components/Loader/Loader';
	import { mapActions, mapGetters } from 'vuex';
	import TableComponent from '../../components/Table/Table';
	import PaginationMixin from '../../components/mixins/pagination';

	export default {
		name: 'Clients',
		mixins: [PaginationMixin],
		components: {
			Footer,
			ClientForm,
			Loader,
			TableComponent,
		},
		data() {
			return {
				page: 1,
				perPage: 10,
				isEdit: false,
				clientId: '',
				columns: [
					{ name: 'name', width: 35, title: 'Имя' },
					{ name: 'email', width: 40, title: 'email' },
					{ name: 'actions', width: 25, title: 'Действия' },
				],
			}
		},
		computed: {
			...mapGetters('client', ['clients', 'isLoading']),
			isLoaded() {
				return this.isLoading;
			},
			isError() {
			},
			errorMessage() {
			},
			pageCount() {
				return this.calculatePageCount(this.perPage);
			},
		},
		mounted() {
			this.loadClients();
		},
		methods: {
			...mapActions('client', {
				'clientListRequest': 'findAll',
			}),
			loadClients() {
				this.clientListRequest({
					page: this.page,
					perPage: this.perPage,
				});
			},
			editClient(id) {
				this.isEdit = true;
				this.clientId = id;
			},
			cancelEdit() {
				this.isEdit = false;
				this.clientId = '';
			},
			changePage(pageNum) {
				this.$set(this, 'page', pageNum);
				this.loadClients();
			},
			showClient(id){
				this.$router.push({path: `/clients/${id.toString()}`})
			}
		},
	}
</script>
<style lang="scss">
	.clients-page .table td {
		vertical-align : middle;
	}
</style>
