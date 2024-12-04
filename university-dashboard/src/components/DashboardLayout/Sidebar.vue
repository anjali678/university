<template>
  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" @click="$router.push('dashboard')">
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
      </div>
      <div class="sidebar-brand-text mx-3">{{ role }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <li v-if="$store.state.role==='Admin' || $store.state.role==='Academic Head'"
        class="nav-item" :class="{'active': isDashboard}">
      <a class="nav-link" @click="$router.push('dashboard')">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>

    <li v-if="$store.state.role==='Admin' || $store.state.role==='Academic Head'"
        class="nav-item" :class="{'active': isCourses}">
      <a class="nav-link" @click="$router.push('/courses')">
        <i class="fas fa-fw fa-book"></i>
        <span>Courses</span>
      </a>
    </li>

    <li class="nav-item" :class="{'active': isModules}">
      <a class="nav-link" @click="$router.push('/modules')">
        <i class="fas fa-fw fa-th"></i>
        <span>Modules</span>
      </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

  </ul>
</template>

<script>
export default {
  name: 'Sidebar',
  data() {
    return {
      role: this.$store.state.role,
    }
  },
  computed: {
    isDashboard() {
      return this.$route.path === '/dashboard';
    },
    isCourses() {
      return this.$route.path === '/courses';
    },
    isModules() {
      return this.$route.path === '/modules';
    }
  }
}
</script>
