import { createRouter, createWebHistory } from "vue-router";

const routes = [
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
    path: "/login",
    component: () => import("@/views/login_page.vue"),
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
