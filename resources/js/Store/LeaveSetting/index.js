import axios from "../axios";

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
                `common/leaveSetting`,
                leaveSettings
            );

            state.commit("SET_LEAVE_SETTINGS", data);
        },
        async createLeaveSetting({ dispatch }, leaveSetting) {
            await axios.post(`common/leaveSetting`, leaveSetting);
            dispatch("fetchLeaveSettings");
        },

        async deleteDesignation({ dispatch }, id) {
            await axios.delete(`common/designation/${id}`);
            dispatch("fetchDesignations");
        },

        async editDesignation({ dispatch }, designation) {
            const { id, name, responsibilities } = designation;
            await axios.put(`common/designation/${id}`, {
                name,
                responsibilities,
            });
            dispatch("fetchLeaves");
        },

        async searchEmployee({ commit }) {
            const { data } = await axios.get(`common/leaves/findEmployee`);
            commit("SET_SEARCH_EMPLOYEES", data);
        },

        async fetchDesignation(_, id) {
            const { data } = await axios.get(
                `${baseUrl}common/designation/${id}/edit`
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
