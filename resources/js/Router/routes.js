const routes = [
    {
        path: "/dashboard",
        component: () => import("../Pages/Dashboard.vue"),
        name: "dashboard",
    },
    {
        path: "/about",
        component: () => import("../Pages/About.vue"),
        name: "about",
    },
    {
        path: "/login",
        component: () => import("../Pages/Login.vue"),
        name: "Login",
    },
    {
        path: "/department/list",
        component: async () => import("../Pages/Department/DepartmentList.vue"),
        name: "department.list",
    },
    {
        path: "/department/create",
        component: async () =>
            import("../Pages/Department/DepartmentCreate.vue"),
        name: "department.create",
    },
    {
        path: "/department/edit/:id",
        component: async () => import("../Pages/Department/DepartmentEdit.vue"),
        name: "department.edit",
    },
    {
        path: "/:pathMatch(.*)*",
        component: () => import("../Pages/NotFound.vue"),
    },
];

export default routes;
