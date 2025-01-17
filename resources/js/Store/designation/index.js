import axios from "axios";
import { baseUrl } from "../apiEnv";

const designation = {
    namespaced: true,
    state: () => ({
        designation: {},
        designations: {
            data: [],
            current_page: 1,
            last_page: 1,
            per_page: 10,
            total: 0,
        },
    }),
    mutations: {
        SET_DESIGNATIONS(state, designations) {
            state.designations = designations;
        },
        SET_DESIGNATION(state, designation) {
            state.designation = designation;
        },
    },
    actions: {
        setDesignation({ commit }, designation) {
            commit("SET_DESIGNATION", designation);
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
            dispatch("fetchDesignations");
        },
        async fetchDesignations({ commit }) {
            const { data } = await axios.get(`${baseUrl}common/designation`, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "access_token"
                    )}`,
                    "Content-Type": "application/json",
                },
            });

            commit("SET_DESIGNATIONS", data.designations);
        },
    },
    getters: {
        getDesignation: (state) => state.designation,
        getDesignations: (state) => state.designations,
    },
};

export default designation;
