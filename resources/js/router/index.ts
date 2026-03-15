import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '@/stores/auth';

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/login',
      name: 'login',
      component: () => import('@/components/Login.vue'),
      meta: { guest: true }
    },
    {
      path: '/register',
      name: 'register',
      component: () => import('@/components/Register.vue'),
      meta: { guest: true }
    },
    {
      path: '/',
      component: () => import('@/layouts/MainLayout.vue'),
      meta: { requiresAuth: true },
      children: [
        {
          path: '',
          name: 'dashboard',
          component: () => import('@/components/Dashboard.vue')
        },
        // {
        //   path: 'productos',
        //   name: 'products',
        //   component: () => import('@/components/Products.vue')
        // },
        // Agrega más rutas hijas aquí
      ]
    },
    {
      path: '/companies',
      name: 'companies',
      component: () => import('@/views/companies/index.vue'),
      meta: { requiresAuth: true }
    },
    {
      path: '/companies/:id',
      name: 'company-detail',
      component: () => import('@/views/companies/CompanyDetail.vue'),
      meta: { requiresAuth: true }
    }
  ]
});

// Navigation guard
router.beforeEach((to, from, next) => {
  const auth = useAuthStore();
  
  if (to.meta.requiresAuth && !auth.isAuthenticated) {
    next('/login');
  } else if (to.meta.guest && auth.isAuthenticated) {
    next('/');
  } else {
    next();
  }
});

export default router;