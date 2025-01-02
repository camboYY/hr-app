import routes from "./routes";

import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
    history: createWebHistory(),
    routes,
});
const isAuthenticated = !!localStorage.getItem("access_token");
router.beforeEach(async (to, from) => {
    if (
        // make sure the user is authenticated
        !isAuthenticated &&
        // ❗️ Avoid an infinite redirect
        to.name !== "Login"
    ) {
        // redirect the user to the login page
        return { name: "Login" };
    }
});

export default router;
