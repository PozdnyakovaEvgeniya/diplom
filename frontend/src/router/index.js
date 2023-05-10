import { createRouter, createWebHistory } from "vue-router";

const routes = [
  {
    name: "main",
    path: "/main/:year/:month",
    component: () => import("@/views/main_page.vue"),
    children: [
      {name: "main", path: "", redirect: to => {return {path: `/main/${to.params.year}/${to.params.month}/department`}}},
      {
        name: "department",
        path: "department/",
        component: () => import("@/views/department_page.vue"),
      },
      {
        name: "employee",
        path: "employee/:id",
        component: () => import("@/views/employee_page.vue"),
      },
    ]
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
