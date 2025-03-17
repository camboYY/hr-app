import axios from "axios";
import { baseUrl } from "../apiEnv";

const leaveSetting = {
    namespaced: true,
    state: () => ({
        leaveSetting: {},
        leaveSettings: {
            data: [],
            current_page: 1,
            last_page: 1,
            per_page: 10,
            total: 0,
        },
    }),
    mutations: {
        SET_LEAVE_SETTINGS(state, leaveSettings) {
            state.leaveSettings = leaveSettings;
        },
        SET_LEAVE_SETTING(state, leaveSetting) {
            state.leaveSetting = leaveSetting;
        },
    },
    actions: {
        async fetchLeaveSettings(state) {
            const { data } = await axios.get(
                `${baseUrl}common/leaveSetting`,
                leaveSettings,
                {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "access_token"
                        )}`,
                        "Content-Type": "application/json",
                    },
                }
            );

            state.commit("SET_LEAVE_SETTINGS", data);
        },
        async createLeaveSetting({ dispatch }, leaveSetting) {
            await axios.post(`${baseUrl}common/leaveSetting`, leaveSetting, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "access_token"
                    )}`,
                    "Content-Type": "application/json",
                },
            });
            dispatch("fetchLeaveSettings");
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

        async searchEmployee({ commit }) {
            const { data } = await axios.get(
                `${baseUrl}common/leaves/findEmployee`,
                {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "access_token"
                        )}`,
                        "Content-Type": "application/json",
                    },
                }
            );
            commit("SET_SEARCH_EMPLOYEES", data);
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
        searchEmployees: (state) => state.employees,
    },
};

export default leaveSetting;
