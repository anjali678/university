<template>
  <div id="page-top">
    <div id="wrapper">
      <Sidebar />

      <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
          <Navbar />

          <!-- Begin Page Content -->
          <div class="container-fluid">
            <router-view />
          </div>
        </div>

        <Footer />
      </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>
  </div>
</template>

<script>
import Sidebar from '@/components/DashboardLayout/Sidebar.vue'
import Navbar from '@/components/DashboardLayout/Navbar.vue'
import Footer from '@/components/DashboardLayout/Footer.vue'

export default {
  components: {
    Sidebar,
    Navbar,
    Footer
  },
}
</script>
