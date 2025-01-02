import { baseUrl } from "../apiEnv";

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
            await axios.delete(`${baseUrl}common/department/${id}`, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "access_token"
                    )}`,
                    "Content-Type": "application/json",
                },
            });
            dispatch("fetchDepartments");
        },
        async editDepartment({ dispatch }, department) {
            const { id, name, description } = department;
            await axios.put(
                `${baseUrl}common/department/${id}`,
                { name, description },
                {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "access_token"
                        )}`,
                        "Content-Type": "application/json",
                    },
                }
            );
            dispatch("fetchDepartments");
        },
        async fetchDepartments({ commit }) {
            const { data } = await axios.get(`${baseUrl}common/department`, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "access_token"
                    )}`,
                    "Content-Type": "application/json",
                },
            });
            commit("SET_DEPARTMENTS", data.departments);
        },
        async createDepartment({ dispatch }, department) {
            await axios.post(`${baseUrl}common/department`, department, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "access_token"
                    )}`,
                    "Content-Type": "application/json",
                },
            });
            dispatch("fetchDepartments");
        },
    },
    getters: {
        departments: (state) => state.departments,
        department: (state) => state.department,
    },
};

export default DepartmentStore;
