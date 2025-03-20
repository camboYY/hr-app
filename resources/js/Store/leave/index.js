import axios from "axios";
import { baseUrl } from "../apiEnv";

const leave = {
    namespaced: true,
    state: () => ({
        leave: {},
        leaveTypes: [],
        employees: [],
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
        SET_SEARCH_EMPLOYEES(state, employees) {
            state.employees = employees;
        },
        SET_LEAVE_TYPES(state, leaveTypes) {
            state.leaveTypes = leaveTypes;
        },
    },
    actions: {
        setLeave({ commit }, leave) {
            commit("SET_LEAVE", leave);
        },
        async submitLeaveRequest({ dispatch }, leave) {
            await axios.post(`${baseUrl}common/leaves/request`, leave, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "access_token"
                    )}`,
                    "Content-Type": "application/json",
                },
            });
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
        async getLeave({ commit }, { id }) {
            await axios.get(`${baseUrl}common/leaves/${id}`, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "access_token"
                    )}`,
                    "Content-Type": "application/json",
                },
            });
            dispatch("fetchLeaves");
        },
        async fetchLeaves(
            { commit },
            { page, perPage, search, fromDate, toDate }
        ) {
            const { data } = await axios.get(
                `${baseUrl}common/leaves/request`,
                {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "access_token"
                        )}`,
                        "Content-Type": "application/json",
                    },
                    params: {
                        page,
                        perPage,
                        search,
                        fromDate,
                        toDate,
                    },
                }
            );

            commit("SET_LEAVES", data);
        },
        async searchEmployee({ commit }, search) {
            const { data } = await axios.get(
                `${baseUrl}common/leaves/findEmployee`,
                {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "access_token"
                        )}`,
                        "Content-Type": "application/json",
                    },
                    params: {
                        query: search,
                    },
                }
            );
            commit("SET_SEARCH_EMPLOYEES", data);
        },

        async fetchLeaveTypes({ commit }) {
            const { data } = await axios.get(`${baseUrl}common/leave-types`, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "access_token"
                    )}`,
                    "Content-Type": "application/json",
                },
            });
            commit("SET_LEAVE_TYPES", data.data);
        },
    },
    getters: {
        leave: (state) => state.leave,
        leaves: (state) => state.leaves,
        searchEmployees: (state) => state.employees,
        leaveTypes: (state) => state.leaveTypes,
    },
};

export default leave;
