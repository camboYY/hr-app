import { baseUrl } from "../apiEnv";

const DepartmentStore = {
    namespaced: true,
    state: () => ({
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
            console.log(departments.data);
            state.departments.data = departments.data;
        },
    },
    actions: {
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
    },
};

export default DepartmentStore;
