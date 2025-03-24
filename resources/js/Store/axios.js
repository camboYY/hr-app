import axios from "axios";
import router from "../Router/routes";
import { baseUrl } from "./apiEnv";
import store from "./index";

const api = axios.create({
    baseURL: baseUrl,
});

// 🔹 Request Interceptor: Attach `access_token` to every request
api.interceptors.request.use(
    (config) => {
        const token = store.state.token || localStorage.getItem("access_token");

        if (token) {
            config.headers["Authorization"] = `Bearer ${token}`;
        }
        config.headers["Content-Type"] = "application/json";

        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

api.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response && error.response.status === 401) {
            store.dispatch("userLogout"); // Log out the user if token is invalid
            router.push("/login");
        }
        return Promise.reject(error);
    }
);

export default api;
