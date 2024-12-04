<template>
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <!--      <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i-->
    <!--        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>-->
  </div>

  <div class="row mx-2 card p-3">

    <div v-if="faculties.length>0">
      <h4>Faculties</h4>
      <ul>
        <li v-for="faculty in faculties" :key="faculty.id">{{ faculty.name }}</li>
      </ul>
    </div>

    <div v-if="departments.length>0">
      <h4>Departments</h4>
      <ul>
        <li v-for="department in departments" :key="department.id">
          {{ department.name }} (Faculty: {{ department.faculty.name }})
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import DashboardLayout from '../../layouts/Dashboard.vue'
import axios from '../../axios';

export default {
  components: {
    DashboardLayout,
  },
  data() {
    return {
      user: {},
      faculties: [],
      departments: [],
    };
  },
  mounted() {
    console.log('test')
    this.fetchFaculties();
    this.fetchDepartments();
  },
  methods: {
    async fetchFaculties() {
      try {
        const response = await axios.get('/api/faculties');
        this.faculties = response.data;
      } catch (error) {
        console.error("Error fetching faculties:", error);
      }
    },
    async fetchDepartments() {
      try {
        const response = await axios.get('/api/departments');
        this.departments = response.data;
      } catch (error) {
        console.error("Error fetching departments:", error);
      }
    }
  },
};
</script>
