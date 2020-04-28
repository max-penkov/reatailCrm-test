<template lang="pug">
  .projects-form
    Widget(
      :title="`<h4>${getTitle}</h4>`"
      customHeader
    )
      br
      legend
      b-alert.alert-sm(variant='danger', :show='isError')
        | {{ errorMessage }}
      b-form-group
        ValidationObserver(v-slot="{ passes }" ref="form")
          b-form(@submit.prevent="passes(saveClient)")
            ValidationProvider(name="Name" rules="required" v-slot="{ errors }")
              b-form-group(
                horizontal=""
                label="Name"
                label-for="name"
                label-class="text-md-right"
                :label-cols="4"
                breakpoint="md"
              )
                b-form-input#name(
                  type="text"
                  v-model="form.name"
                )
                .validation-error.no-pl {{ errors[0] }}
            b-form-group(
              horizontal=""
              label="E-mail"
              label-for="email"
              label-class="text-md-right"
              :label-cols="4"
              breakpoint="md"
            )
              b-form-input#email(
              	type="text"
                v-model="form.email"
              )
            b-form-group(
              horizontal=""
              label="Phone"
              label-for="phone"
              label-class="text-md-right"
              :label-cols="4"
              breakpoint="md"
            )
              b-form-input#phone(
              	type="text"
                v-model="form.phone"
              )
            b-form-group.form-action(horizontal="" label="" label-for="transparent-field" :label-cols="4" breakpoint="md")
              b-button.mr-xs(
                variant="primary"
                type="submit"
                :disabled="isLoading"
              ) {{ saveBtnText }}
              b-button(
                v-if="isEdit"
                @click="cancelEdit"
                variant="inverse"
              ) {{ 'Отмена' }}
</template>
<script>
	import { mapActions, mapGetters } from 'vuex';
	import { extend, ValidationProvider, ValidationObserver } from 'vee-validate';
	import { required } from 'vee-validate/dist/rules';

	extend('required', required);

	export default {
		name: 'ClientForm',
		components: {
			ValidationProvider,
			ValidationObserver,
		},
		props: {
			isEdit: {
				type: Boolean,
				default: false,
			},
			clientId: {
				type: String,
				default: 'null',
			},
		},
		data() {
			return {
				form: {
					id: null,
					name: '',
					email: '',
					phone: '',
				},
			}
		},
		computed: {
			...mapGetters('client',[
				'isLoading',
				'client'
			]),
			getTitle() {
				return this.isEdit ? 'Изменение' : 'Создание';
			},
			saveBtnText() {
				if (this.isLoading) {
					return 'Отпрвка...'
				}
				return this.isEdit ? 'Сохранить' : 'Добавить';
			},
			isError() {
			},
			errorMessage() {
			},
		},
		watch: {
			clientId(val) {
				if (val && val !== '') {
					let currentClient = this.client(val);
					this.form.id = currentClient.id;
					this.form.name = currentClient.name;
					this.form.email = currentClient.email;
					this.form.phone = currentClient.phone;
				}
			},
		},
		mounted() {
		},
		methods: {
			...mapActions('client', ['create', 'sendForm']),
			clearForm() {
				this.form.id = null;
				this.form.name = '';
				this.form.email = '';
				this.form.phone = '';
			},
			cancelEdit() {
				this.clearForm();
				this.$emit('cancelEdit');
			},
			async saveClient() {
				let request = await this.sendForm(this.form);
				if (request) {
					this.clearForm();
					flash('Клиент был успешно добавлен');
					this.$refs.form.reset();
				}
			},
		},
	}
</script>
<style lang="scss">
	.projects-page .table td {
		vertical-align : middle;
	}
</style>
