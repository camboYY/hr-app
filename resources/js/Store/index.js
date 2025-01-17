import { createStore } from "vuex";
import Auth from "./auth";
import Department from "./department";
import Designation from "./designation";
import Employee from "./employee";

const store = createStore({
    modules: {
        Auth,
        Department,
        Designation,
        Employee,
    },
});

export default store;
