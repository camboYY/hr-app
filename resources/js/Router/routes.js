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
        path: "/designation/list",
        component: async () =>
            import("../Pages/Designation/DesignationList.vue"),
        name: "designation.list",
    },
    {
        path: "/designation/create",
        component: async () =>
            import("../Pages/Designation/DesignationCreate.vue"),
        name: "designation.create",
    },
    {
        path: "/designation/edit/:id",
        component: async () =>
            import("../Pages/Designation/DesignationEdit.vue"),
        name: "designation.edit",
    },
    {
        path: "/employee/list",
        component: async () => import("../Pages/Employee/EmployeeList.vue"),
        name: "employee.list",
    },
    {
        path: "/employee/create",
        component: async () => import("../Pages/Employee/EmployeeCreate.vue"),
        name: "employee.create",
    },
    {
        path: "/employee/edit/:id",
        component: async () => import("../Pages/Employee/EmployeeEdit.vue"),
        name: "employee.edit",
    },
    {
        path: "/leave/request",
        component: async () => import("../Pages/Leave/LeaveRequest.vue"),
        name: "leave.request",
    },
    {
        path: "/leave/list",
        component: async () => import("../Pages/Leave/LeaveReport.vue"),
        name: "leave.list",
    },
    {
        path: "/leave/check",
        component: async () => import("../Pages/Leave/LeaveCheck.vue"),
        name: "leave.check",
    },
    {
        path: "/:pathMatch(.*)*",
        component: () => import("../Pages/NotFound.vue"),
    },
];

export default routes;
