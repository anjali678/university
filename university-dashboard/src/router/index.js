import { createRouter, createWebHistory } from 'vue-router';
import store from '../store';
// pages
import Login from '../views/pages/login.vue';
import Dashboard from '../views/pages/dashboard.vue';
import Course from '../views/pages/course.vue';
import Module from '../views/pages/module.vue';
// Layouts
import DashboardLayout from "../layouts/Dashboard.vue";

const routes = [
  {
    path: '/login',
    name: 'login',
    component: Login
  },
  {
    path: "/",
    component: DashboardLayout,
    children: [
      {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta: { requiresAuth: true, roles: ['Admin', 'Academic Head']  } // Protect this route with auth
      },
      {
        path: '/courses',
        name: 'courses',
        component: Course,
        meta: { requiresAuth: true, roles: ['Admin', 'Academic Head'] }
      },
      {
        path: '/modules',
        name: 'modules',
        component: Module,
        meta: { requiresAuth: true },
        props: true,
      },
    ]
  },
  {
    path: '/',
    redirect: (to) => {
      return !!localStorage.getItem('authToken') ? '/dashboard' : '/login';
    },
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

// Global route guard to check authentication
router.beforeEach(async(to, from, next) => {
  if (to.matched.some((record) => record.meta.requiresAuth)) {
    // If the route requires authentication, check if the user is authenticated
    try {
      await store.dispatch('fetchUser');
      const userRole = store.state.role;

      if (to.meta.roles && !to.meta.roles.includes(userRole)) {
        if (to.name === 'dashboard') {
          return next({ name: 'modules' });
        }
        else alert('Access Denied: Insufficient Permissions');
      }
      next();
    } catch (err) {
      next('/login');
    }
  } else {
    next(); // Continue if route does not require authentication
  }
});

export default router;
