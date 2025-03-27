import axios from "../axios";

const leave = {
    namespaced: true,
    state: () => ({
        leave: {},
        leaveTypes: [],
        employees: [],
        leaves: [],
        leavePendingApproval: [],
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
        SET_LEAVES_PENDING_APP(state, leavePendingApproval) {
            state.leavePendingApproval = leavePendingApproval;
        },
    },
    actions: {
        async approvePendingLeave({ dispatch }, { leaveId, status, comment }) {
            await axios.put(`common/leaves/${leaveId}/approve-request`, {
                leave_status: status,
                comment,
            });
            dispatch("fetchLeaves");
        },
        async fetctPendingLeaveApproval({ commit }) {
            const { data } = await axios.get(`common/leaves/pending`);
            commit("SET_LEAVES_PENDING_APP", {
                data: data.data,
                total: data.total[0].totalRecords,
            });
        },
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
        leavePendingApproval: (state) => state.leavePendingApproval,
    },
};

export default leave;
