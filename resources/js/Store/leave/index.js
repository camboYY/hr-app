import axios from "../axios";

const leave = {
    namespaced: true,
    state: () => ({
        leave: {},
        leaveTypes: [],
        employees: [],
        leaves: [],
    }),
    mutations: {
        SET_LEAVES(state, leaves) {
            state.leaves = leaves;
        },
        SET_SEARCH_EMPLOYEES(state, employees) {
            state.employees = employees;
        },
        SET_LEAVE_TYPES(state, leaveTypes) {
            state.leaveTypes = leaveTypes;
        },
    },
    actions: {
        async submitLeaveRequest({ dispatch }, leave) {
            await axios.post(`common/leaves/request`, leave);
        },
        async cancelLeave({ dispatch }, { id, leave_status }) {
            await axios.put(`common/leaves/${id}/cancel`, {
                leave_status: leave_status,
            });
        },
        async getLeave({ commit }, { id }) {
            await axios.get(`common/leaves/${id}`);
            dispatch("fetchLeaves");
        },
        async fetchLeaves(
            { commit },
            { page, perPage, search, fromDate, toDate }
        ) {
            const { data } = await axios.get(`common/leaves/request`, {
                params: {
                    page,
                    perPage,
                    search,
                    fromDate,
                    toDate,
                },
            });

            commit("SET_LEAVES", {
                data: data.data,
                total: data.total[0].totalRecords,
            });
        },
        async searchEmployee({ commit }, search) {
            const { data } = await axios.get(`common/leaves/findEmployee`, {
                params: {
                    query: search,
                },
            });
            commit("SET_SEARCH_EMPLOYEES", data);
        },

        async fetchLeaveTypes({ commit }) {
            const { data } = await axios.get(`common/leave-types`);
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
