import api from "../instanceApi";

export default {
	findAll(params) {
		return api().get("/clients", {params: params});
	},

	create(data) {
		return api().post("/clients/create", data);
	},

	delete(id) {
		return api().delete("/clients/" + id);
	},

	update(data) {
		let id = data['id'];
		delete data['id'];
		return api().put("/clients/" + id + "/update", data);
	},

	show(id) {
		return api().get("/clients/show/" + id);
	}
};