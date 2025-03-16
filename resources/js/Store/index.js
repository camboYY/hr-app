import { createStore } from "vuex";
import Auth from "./auth";
import Department from "./department";
import Designation from "./designation";
import Employee from "./employee";
import Leave from "./leave";

const store = createStore({
    modules: {
        Auth,
        Department,
        Designation,
        Employee,
        Leave,
    },
});

export default store;
