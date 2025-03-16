import axios from "axios";
import { baseUrl } from "../apiEnv";

const leave = {
    namespaced: true,
    state: () => ({
        leave: {},
        leaves: {
            data: [],
            current_page: 1,
            last_page: 1,
            per_page: 10,
            total: 0,
        },
    }),
    mutations: {
        SET_LEAVES(state, leaves) {
            state.leaves = leaves;
        },
        SET_LEAVE(state, leave) {
            state.leave = leave;
        },
    },
    actions: {
        setDesignation({ commit }, designation) {
            commit("SET_LEAVE", designation);
        },
        async createDesignation({ dispatch }, designation) {
            await axios.post(`${baseUrl}common/designation`, designation, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "access_token"
                    )}`,
                    "Content-Type": "application/json",
                },
            });
            dispatch("fetchDesignations");
        },

        async deleteDesignation({ dispatch }, id) {
            await axios.delete(`${baseUrl}common/designation/${id}`, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "access_token"
                    )}`,
                    "Content-Type": "application/json",
                },
            });
            dispatch("fetchDesignations");
        },
        async editDesignation({ dispatch }, designation) {
            const { id, name, responsibilities } = designation;
            await axios.put(
                `${baseUrl}common/designation/${id}`,
                { name, responsibilities },
                {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "access_token"
                        )}`,
                        "Content-Type": "application/json",
                    },
                }
            );
            dispatch("fetchLeaves");
        },
        async fetchLeaves({ commit }) {
            const { data } = await axios.get(
                `${baseUrl}common/leaves/request`,
                {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "access_token"
                        )}`,
                        "Content-Type": "application/json",
                    },
                }
            );

            commit("SET_LEAVES", data.leaveRequests);
        },

        async fetchDesignation(_, id) {
            const { data } = await axios.get(
                `${baseUrl}common/designation/${id}/edit`,
                {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "access_token"
                        )}`,
                        "Content-Type": "application/json",
                    },
                }
            );
            return data;
        },
    },
    getters: {
        leave: (state) => state.leave,
        leaves: (state) => state.leaves,
    },
};

export default leave;
