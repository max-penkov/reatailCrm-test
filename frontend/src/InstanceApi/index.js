import axios from 'axios';

const api = (url = process.env.VUE_APP_API_URL) => {
	let newInstance = axios.create({
		baseURL: url,
		headers: {
			'Content-Type': 'application/json'
		}
	});

	return newInstance;
}

export default api;