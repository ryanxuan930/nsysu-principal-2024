import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/HomeView.vue';
import AdminView from '../views/AdminView.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/admin',
      name: 'admin',
      component: AdminView,
      children: [
        {
          path: '/admin',
          name: 'adminHome',
          component: () => import('../views/admin/HomePage.vue'),
        },
        {
          path: 'scan',
          name: 'adminScan',
          component: () => import('../views/admin/ScanPage.vue'),
        },
        {
          path: 'seat',
          name: 'adminSeat',
          component: () => import('../views/admin/SeatPage.vue'),
        },
      ],
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/LoginView.vue'),
    },
  ],
});

export default router;
