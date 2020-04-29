import ClientAPI from "../api/client";
import {
	UPDATING_CLIENT,
	UPDATING_CLIENT_ERROR,
	UPDATING_CLIENT_SUCCESS,
	FETCHING_CLIENTS,
	FETCHING_CLIENTS_SUCCESS,
	FETCHING_CLIENTS_ERROR,
	CREATING_CLIENT, CREATING_CLIENT_SUCCESS,
	CREATING_CLIENT_ERROR,
	PAGINATION,
	SHOWING_CLIENT,
	SHOWING_CLIENT_SUCCESS,
	SHOWING_CLIENT_ERROR,
} from "./const/clients";
import Vue from 'vue';

export default {
	namespaced: true,
	state: {
		client: null,
		clients: [],
		history: [],
		pagination: null,
		isLoading: false,
		error: null
	},

	getters: {
		isLoading(state) {
			return state.isLoading;
		},
		hasError(state) {
			return state.error !== null;
		},
		error(state) {
			return state.error;
		},
		hasClients(state) {
			return state.clients.length > 0;
		},
		clients(state) {
			return state.clients;
		},
		client: (state) => (id) => state.clients.find(todo => todo.id === id),
		pagination(state) {
			return state.pagination;
		},
		currentClient(state){
			return state.client;
		},
		history(state){
			return state.history
		}
	},

// mutations
	mutations: {
		[SHOWING_CLIENT](state) {
			state.isLoading = true;
			state.error = null;
			state.clients = [];
		},
		[SHOWING_CLIENT_SUCCESS](state, data) {
			state.isLoading = false;
			state.error = null;
			state.client = data.client;
			state.history = data.history
		},
		[SHOWING_CLIENT_ERROR](state, error) {
			state.isLoading = false;
			state.error = error;
			state.histories = [];
			state.client = null
		},
		[FETCHING_CLIENTS](state) {
			state.isLoading = true;
			state.error = null;
			state.clients = [];
		},
		[FETCHING_CLIENTS_SUCCESS](state, clients) {
			state.isLoading = false;
			state.error = null;
			state.clients = clients;
		},
		[FETCHING_CLIENTS_ERROR](state, error) {
			state.isLoading = false;
			state.error = error;
			state.clients = [];
		},
		[CREATING_CLIENT](state) {
			state.isLoading = true;
			state.error = null;
		},
		[CREATING_CLIENT_SUCCESS](state, client) {
			state.isLoading = false;
			state.error = null;
			state.clients.unshift(client);
		},
		[CREATING_CLIENT_ERROR](state, error) {
			state.error = error;
			state.clients = [];
		},
		[UPDATING_CLIENT](state) {
			state.isLoading = true;
			state.error = null;
		},
		[UPDATING_CLIENT_SUCCESS](state, client) {
			state.isLoading = false;
			state.error = null;
			let arrKey = null;
			state.clients.find((item, key) => {
				if (item.id === client.id) {
					arrKey = key;
					return true;
				}
			});
			Vue.set(state.clients, arrKey, client)
		},
		[UPDATING_CLIENT_ERROR](state, error) {
			state.isLoading = false;
			state.error = error;
		},
		[PAGINATION](state, {data}) {
			state.pagination = data;
		},
	},

	actions: {
		async create({commit}, message) {
			commit(CREATING_CLIENT);
			try {
				let response = await ClientAPI.create(message);
				commit(CREATING_CLIENT_SUCCESS, response.data);
				return Promise.resolve(response.data);
			} catch (error) {
				commit(CREATING_CLIENT_ERROR, error.response.data.error);
				return Promise.reject(error);
			}
		}
		,

		async findAll({commit}, {page, perPage}) {
			commit(FETCHING_CLIENTS);
			try {
				let response = await ClientAPI.findAll({page, perPage});
				if (response.data.pagination) {
					commit(PAGINATION, {data: response.data.pagination});
				}
				if (response.data.collection) {
					commit(FETCHING_CLIENTS_SUCCESS, response.data.collection);
				}
				return Promise.resolve(response.data);
			} catch (error) {
				commit(FETCHING_CLIENTS_ERROR, error.response.data.error);
				return Promise.reject(error);
			}
		},

		async update({commit}, data) {
			commit(UPDATING_CLIENT);
			try {
				let response = await ClientAPI.update(data);
				commit(UPDATING_CLIENT_SUCCESS, response.data);
				return Promise.resolve(data);
			} catch (error) {
				commit(UPDATING_CLIENT_ERROR, error);
				return Promise.reject(error);
			}
		},

		async sendForm(context, params) {
			if (params.id) {
				return context.dispatch('update', params);
			} else {
				return context.dispatch('create', params);
			}
		},

		async show({commit}, id) {
			commit(SHOWING_CLIENT);
			try {
				let response = await ClientAPI.show(id);
				commit(SHOWING_CLIENT_SUCCESS, response.data);
				return Promise.resolve(response.data);
			} catch (error) {
				commit(SHOWING_CLIENT_ERROR, error);
				return Promise.reject(error);
			}
		}
	}
}