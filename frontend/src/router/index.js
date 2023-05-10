import { createRouter, createWebHistory } from "vue-router";

const routes = [
  {
    path: "/main/:year/:month",
    component: () => import("@/views/main_page.vue"),
  },
  {
    path: "/employee/:id",
    component: () => import("@/views/employee_page.vue"),
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
