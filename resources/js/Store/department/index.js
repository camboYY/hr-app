import axios from "../axios";

const DepartmentStore = {
    namespaced: true,
    state: () => ({
        department: {},
        departments: {
            data: [],
            current_page: 1,
            last_page: 1,
            per_page: 10,
            total: 0,
        },
    }),
    mutations: {
        SET_DEPARTMENTS(state, departments) {
            state.departments = departments;
        },
        SET_DEPARTMENT(state, department) {
            state.department = department;
        },
    },
    actions: {
        setDepartment({ commit }, department) {
            commit("SET_DEPARTMENT", department);
        },
        async deleteDepartment({ dispatch }, id) {
            await axios.delete(`common/department/${id}`);
            dispatch("fetchDepartments");
        },
        async editDepartment({ dispatch }, department) {
            const { id, name, description } = department;
            await axios.put(`common/department/${id}`, { name, description });
            dispatch("fetchDepartments");
        },
        async fetchDepartments({ commit }) {
            const { data } = await axios.get(`common/department`);
            commit("SET_DEPARTMENTS", data.departments);
        },
        async fetchDepartment({ commit }, id) {
            const { data } = await axios.get(`common/department/${id}/edit`);
            return data;
        },
        async createDepartment({ dispatch }, department) {
            await axios.post(`common/department`, department);
            dispatch("fetchDepartments");
        },
    },
    getters: {
        departments: (state) => state.departments,
        department: (state) => state.department,
    },
};

export default DepartmentStore;
