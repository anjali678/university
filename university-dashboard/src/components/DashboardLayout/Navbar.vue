<template>
  <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (mobile view) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
      <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

<!--      <div class="topbar-divider d-none d-sm-block"></div>-->

      <!-- Nav Item - User Information -->
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
           data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ userName }}</span>
          <img class="img-profile rounded-circle" src="../../assets/img/undraw_profile.svg" alt="User Profile">
        </a>
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="#">
            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
            Profile
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" @click="logout()" data-bs-toggle="modal" data-bs-target="#logoutModal">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            Logout
          </a>
        </div>
      </li>


    </ul>

  </nav>
</template>

<script>
export default {
  name: 'Navbar',
  computed: {
    userName() {
      return this.$store.state.user ? this.$store.state.user.name : null; // Access the user from Vuex state
    },
  },
  methods: {
    async logout() {
      try {
        await this.$store.dispatch('logout'); // Call the logout action
        this.$router.push({ name: 'login' }); // Redirect to login
      } catch (err) {
        console.error('Logout failed', err);
      }
    },
  },
}
</script>
