import axios from "axios";
import { baseUrl } from "../apiEnv";

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
            const { data } = await axios.get(
                `${baseUrl}common/employee/${id}`,
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

        async updatePhoto(imagePath, id) {
            const { data } = await axios.post(
                `${baseUrl}common/employee/updatePhoto/${id}`,
                imagePath,
                {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "access_token"
                        )}`,
                        "Content-Type": "multipart/form-data",
                    },
                }
            );
            return data;
        },
        async createEmployee({ dispatch }, employee) {
            await axios.post(`${baseUrl}common/employee`, employee, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "access_token"
                    )}`,
                    "Content-Type": "multipart/form-data",
                },
            });
            dispatch("fetchEmployees");
        },

        async deleteEmployee({ dispatch }, id) {
            await axios.delete(`${baseUrl}common/employee/${id}`, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "access_token"
                    )}`,
                    "Content-Type": "application/json",
                },
            });
            dispatch("fetchEmployees");
        },
        async editEmployee({ dispatch }, { employee, id }) {
            console.log({ idddd: id });

            await axios.post(`${baseUrl}common/employee/${id}`, employee, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "access_token"
                    )}`,
                    "Content-Type": "multipart/form-data",
                },
            });
            dispatch("fetchEmployees");
        },
        async fetchEmployees({ commit }, { page, perPage }) {
            const { data } = await axios.get(`${baseUrl}common/employee`, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "access_token"
                    )}`,
                    "Content-Type": "application/json",
                },
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
