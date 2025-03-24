import axios from "../axios";

const employee = {
    namespaced: true,
    state: () => ({
        employee: {},
        employees: {
            data: [],
            current_page: 1,
            last_page: 1,
            per_page: 10,
            total: 0,
        },
    }),
    mutations: {
        SET_EMPLOYEES(state, employees) {
            state.employees = employees;
        },
        SET_EMPLOYEE(state, employee) {
            state.employee = employee;
        },
    },
    actions: {
        setEmployee({ commit }, employee) {
            commit("SET_EMPLOYEE", employee);
        },
        async fetchEmployee(_, id) {
            const { data } = await axios.get(`common/employee/${id}`);

            return data;
        },

        async updatePhoto(imagePath, id) {
            const { data } = await axios.post(
                `common/employee/updatePhoto/${id}`,
                imagePath
            );
            return data;
        },
        async createEmployee({ dispatch }, employee) {
            await axios.post(`common/employee`, employee);
            dispatch("fetchEmployees");
        },

        async deleteEmployee({ dispatch }, id) {
            await axios.delete(`common/employee/${id}`);
            dispatch("fetchEmployees");
        },
        async editEmployee({ dispatch }, { employee, id }) {
            await axios.post(`common/employee/${id}`, employee);
            dispatch("fetchEmployees");
        },
        async fetchEmployees({ commit }, { page, perPage }) {
            const { data } = await axios.get(`common/employee`, {
                params: { page, perPage },
            });
            commit("SET_EMPLOYEES", data);
        },
    },
    getters: {
        employee: (state) => state.employee,
        employees: (state) => state.employees,
    },
};

export default employee;
