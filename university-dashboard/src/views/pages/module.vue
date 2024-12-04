<template>
  <div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Modules</h1>
    </div>

    <button v-if="canCreateCourse" class="btn btn-primary" @click="showCreateModuleModal = true">
      Create New Module
    </button>

    <div class="card shadow mb-4 mt-4">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table" id="dataTable" width="100%" cellspacing="0">
            <thead>
            <tr>
              <th>Name</th>
              <th>Course</th>
              <th>Code</th>
              <th>Credit</th>
              <th>Type</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
            </thead>
            <tbody v-for="module in modules" :key="module.id">
            <tr>
              <td>{{ module.name }}</td>
              <td>{{ module.course.name }}</td>
              <td>{{ module.code }}</td>
              <td>{{ module.credit }}</td>
              <td>{{ module.type }}</td>
              <td>{{ module.state }}</td>
              <td>
                <button class="btn btn-success btn-circle btn-sm mr-1"
                        @click="openUpdateModuleModal(module)"
                ><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger btn-circle btn-sm"
                        @click="deleteModule(module.id)"
                ><i class="fas fa-trash"></i></button>
              </td>
              <td>
                <button class="btn btn-outline-dark btn-sm mr-1"
                        @click="changeState(module)"
                > {{ module.state==='draft' ? 'set as published' : 'set as draft'}}
                </button>
              </td>
            </tr>
            </tbody>
          </table>
          <div v-if="modules.length===0" class="text-center">no data available</div>
        </div>
      </div>
    </div>

    <div v-if="showCreateModuleModal" class="modal fade show align-items-center">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create Module</h5>
            <button class="close" type="button" @click="showCreateModuleModal = false">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form class="user pt-3 px-3" @submit.prevent="createModule">
              <div id="form-card">
                <div class="form-group">
                  <label for="moduleName">Module Name</label>
                  <input
                    id="moduleName"
                    class="form-control"
                    v-model="newModule.name"
                    placeholder="Module Name"
                    required
                  />
                </div>

                <div class="form-group">
                  <label for="seoUrl">Code</label>
                  <input
                    id="code"
                    class="form-control"
                    v-model="newModule.code"
                    placeholder="Code"
                    required
                  />
                </div>

                <div class="form-group">
                  <label for="seoUrl">Description</label>
                  <textarea
                    id="description"
                    class="form-control"
                    v-model="newModule.description"
                    placeholder="Description"
                    required
                  />
                </div>

                <div class="form-group">
                  <label for="faculty">Type</label>
                  <select
                    id="course"
                    v-model="newModule.type"
                    required
                    class="form-control"
                  >
                    <option disabled hidden value="">Select Type</option>
                    <option v-for="type in types" :key="type.key" :value="type.key">
                      {{ type.name }}
                    </option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="faculty">Course</label>
                  <select
                    id="course"
                    v-model="newModule.course_id"
                    required
                    class="form-control"
                  >
                    <option disabled hidden value="">Select Course</option>
                    <option v-for="course in courses" :key="course.id" :value="course.id">
                      {{ course.name }}
                    </option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="seoUrl">Credit</label>
                  <input
                    id="seoUrl"
                    type="number"
                    class="form-control"
                    v-model="newModule.credit"
                    placeholder="Credit"
                    required
                  />
                </div>
              </div>

              <div class="form-group" v-if="error">
                <span class="text-danger">{{ error }}</span>
              </div>
              <div class="modal-footer p-0 pt-3 mt-4">
                <button class="btn btn-secondary" @click="showCreateModuleModal = false">Cancel</button>
                <button class="btn btn-primary mr-0 ml-2" type="submit">Create</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div v-if="showUpdateModuleModal" class="modal fade show align-items-center">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update Module</h5>
            <button class="close" type="button" @click="showUpdateModuleModal = false">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form class="user pt-3 px-3" @submit.prevent="editModule">
              <div id="form-card">
                <div class="form-group">
                  <label for="moduleName">Module Name</label>
                  <input
                    id="moduleName"
                    class="form-control"
                    v-model="selectedModule.name"
                    placeholder="Module Name"
                    required
                  />
                </div>

                <div class="form-group">
                  <label for="seoUrl">Code</label>
                  <input
                    id="code"
                    class="form-control"
                    v-model="selectedModule.code"
                    placeholder="Code"
                    required
                  />
                </div>

                <div class="form-group">
                  <label for="seoUrl">Description</label>
                  <textarea
                    id="description"
                    class="form-control"
                    v-model="selectedModule.description"
                    placeholder="Description"
                    required
                  />
                </div>

                <div class="form-group">
                  <label for="faculty">Type</label>
                  <select
                    id="course"
                    v-model="selectedModule.type"
                    required
                    class="form-control"
                  >
                    <option disabled hidden value="">Select Type</option>
                    <option v-for="type in types" :key="type.key" :value="type.key">
                      {{ type.name }}
                    </option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="faculty">Course</label>
                  <select
                    id="course"
                    v-model="selectedModule.course_id"
                    required
                    class="form-control"
                  >
                    <option disabled hidden value="">Select Course</option>
                    <option v-for="course in courses" :key="course.id" :value="course.id">
                      {{ course.name }}
                    </option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="seoUrl">Credit</label>
                  <input
                    id="seoUrl"
                    type="number"
                    class="form-control"
                    v-model="selectedModule.credit"
                    placeholder="Credit"
                    required
                  />
                </div>
              </div>

              <div class="form-group" v-if="error">
                <span class="text-danger">{{ error }}</span>
              </div>
              <div class="modal-footer p-0 pt-3 mt-4">
                <button class="btn btn-secondary" @click="showUpdateModuleModal = false">Cancel</button>
                <button class="btn btn-primary mr-0 ml-2" type="submit">Update</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { axiosResources } from '@/axios';
import { mapGetters } from 'vuex';
import axios from "@/axios.js";

export default {
  data() {
    return {
      modules: [],
      newModule: {
        name: '',
        code: '',
        description: '',
        course_id: '',
        credit: null,
        type: null,
      },
      types: [
        { key: 'Mandatory', name: 'Mandatory' },
        { key: 'Elective', name: 'Elective' },
      ],
      selectedModule: {},
      courses: [],
      error: null,
      showCreateModuleModal: false,
      showUpdateModuleModal: false
    };
  },
  computed: {
    ...mapGetters(['hasPermission']),
    canViewCourse() {
      return this.hasPermission('view course');
    },
    canCreateCourse() {
      return this.hasPermission('create course');
    },
    canUpdateCourse() {
      return this.hasPermission('update course');
    },
    canDeleteCourse() {
      return this.hasPermission('delete course');
    },
  },
  methods: {
    async fetchCourses() {
      try {
        const response = await axiosResources.fetchCourses(this.$store.state.role);
        this.courses = response.data;
      } catch (error) {
        console.error("Error fetching faculties:", error);
      }
    },
    async fetchModules() {
      try {
        const response = await axiosResources.fetchModules(this.$store.state.role);
        this.modules = response.data;
      } catch (e) {
        console.log(e)
      }
    },
    async createModule() {
      try {
        const response = await axiosResources.createModule(this.$store.state.role, this.newModule);
        this.showCreateModuleModal = false;
        this.error = null
        this.newModule = {
          name: '',
          code: '',
          description: '',
          course_id: '',
          credit: null,
          type: null,
        }
        await this.fetchModules();
      } catch (e) {
        this.error = e.response.data ? e.response.data.message : null
      }
    },
    async deleteModule(moduleId) {
      try {
        await axiosResources.deleteModule(this.$store.state.role, moduleId);
        await this.fetchModules();
      } catch (e) {
        console.log(e)
      }
    },
    async editModule() {
      try {
        const response = await axiosResources.updateModule(this.$store.state.role, this.selectedModule.id, this.selectedModule);
        this.showUpdateModuleModal = false;
        this.error = null
        await this.fetchModules();
      } catch (e) {
        this.error = e.response.data ? e.response.data.message : null
      }
    },
    async changeState(module) {
      try {
        await axiosResources.changeModuleState(this.$store.state.role, module.id, {
          state: module.state==='draft' ? 'published' : 'draft'
        });
        await this.fetchModules();
      } catch (e) {
      }
    },
    openUpdateModuleModal(module) {
      this.selectedModule = module
      this.showUpdateModuleModal = true
    }
  },
  mounted() {
    this.fetchModules();
    this.fetchCourses()
  }
};
</script>

<style scoped>
/* Add styles for modal and list */
</style>
