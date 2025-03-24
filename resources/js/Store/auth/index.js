import axios from "../axios";

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
            const { data } = await axios.post(`auth/login`, {
                email,
                password,
            });
            commit("SET__LOGIN__DATA", data.access_token);
        },
        async userLogout({ commit }) {
            await axios.post(`auth/logout`, null);
            commit("CLEAR_LOGGED_IN_DATA");
        },
    },
    getters: {
        loggedIn: (state) => state.isLoggedIn,
        accessToken: (state) => state.token,
    },
};

export default Auth;
