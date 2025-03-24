import axios from "../axios";

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
            await axios.post(`common/designation`, designation);
            dispatch("fetchDesignations");
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
            dispatch("fetchDesignations");
        },
        async fetchDesignations({ commit }) {
            const { data } = await axios.get(`common/designation`);

            commit("SET_DESIGNATIONS", data.designations);
        },

        async fetchDesignation(_, id) {
            const { data } = await axios.get(`common/designation/${id}/edit`);
            return data;
        },
    },
    getters: {
        getDesignation: (state) => state.designation,
        getDesignations: (state) => state.designations,
    },
};

export default designation;
