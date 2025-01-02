import { createStore } from "vuex";
import Auth from "./auth";
import Department from "./department";

const store = createStore({
    modules: {
        Auth,
        Department,
    },
});

export default store;
