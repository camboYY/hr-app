import axios from "axios";
import { baseUrl } from "../apiEnv";

const Auth = {
    namespaced: true,
    state: () => ({ isLoggedIn: false, token: null }),
    mutations: {
        SET__LOGIN__DATA(state, token) {
            state.token = token;
            localStorage.setItem("access_token", token);
            state.isLoggedIn = !!token;
        },
        CLEAR_LOGGED_IN_DATA: (state) => {
            state.token = null;
            state.isLoggedIn = false;
            localStorage.removeItem("access_token");
        },
    },
    actions: {
        async userLogin({ commit }, { email, password }) {
            const { data } = await axios.post(
                `${baseUrl}auth/login`,
                { email, password },
                {
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "*/*",
                    },
                }
            );
            commit("SET__LOGIN__DATA", data.access_token);
        },
        async userLogout({ commit }) {
            await axios.post(`${baseUrl}auth/logout`, null, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "access_token"
                    )}`,
                    "Content-Type": "application/json",
                },
            });
            commit("CLEAR_LOGGED_IN_DATA");
        },
    },
    getters: {
        loggedIn: (state) => state.isLoggedIn,
        accessToken: (state) => state.token,
    },
};

export default Auth;
