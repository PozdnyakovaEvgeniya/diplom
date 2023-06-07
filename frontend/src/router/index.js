import { createRouter, createWebHistory } from "vue-router";

const routes = [
  {
    path: "/login",
    component: () => import("@/views/login_page.vue"),
  },
  {
    name: "timekeeper-main",
    path: "/timekeeper-main/:year/:month",
    component: () => import("@/views/timekeeper_main_page.vue"),
    children: [
      {
        name: "timekeeper-main",
        path: "",
        redirect: (to) => {
          return {
            name: "department",
            params: { year: to.params.year, month: to.params.year },
          };
        },
      },
      {
        name: "department",
        path: "department/",
        component: () => import("@/views/department_page.vue"),
        children: [
          {
            name: "department",
            path: "",
            redirect: { name: "timesheet" },
          },
          {
            name: "timesheet",
            path: "timesheet/",
            component: () => import("@/views/timesheet_page.vue"),
          },
          {
            name: "shifts",
            path: "shifts/",
            component: () => import("@/views/shifts_page.vue"),
          },
        ],
      },
      {
        name: "employee",
        path: "employee/:id",
        component: () => import("@/views/employee_page.vue"),
      },
    ],
  },
  {
    name: "hr-main",
    path: "/hr-main/:department_id",
    component: () => import("@/views/hr_main_page.vue"),
    children: [
      {
        name: "hr-main",
        path: "",
        redirect: (to) => {
          return {
            name: "employees",
            params: { department_id: to.params.department_id },
          };
        },
      },
      {
        name: "employees",
        path: "employees/",
        component: () => import("@/views/employees_page.vue"),
      },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
