<template>
  <div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Courses</h1>
    </div>

    <button v-if="canCreateCourse" class="btn btn-primary" @click="showCreateCourseModal = true">
      Create New Course
    </button>

    <div v-if="canViewCourse" class="card shadow mb-4 mt-4">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table" id="dataTable" width="100%" cellspacing="0">
            <thead>
            <tr>
              <th>Name</th>
              <th>Faculty</th>
              <th>SEO URL</th>
              <th>Credit</th>
              <th>Status</th>
              <th>Actions</th>
              <th></th>
            </tr>
            </thead>
            <tbody v-for="course in courses" :key="course.id">
            <tr>
              <td>{{ course.name }}</td>
              <td>{{ course.faculty.name }}</td>
              <td>{{ course.seo_url }}</td>
              <td>{{ course.credit }}</td>
              <td>{{ course.state }}</td>
              <td>
                <button class="btn btn-success btn-circle btn-sm mr-1"
                        @click="openUpdateCourseModal(course)"
                ><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger btn-circle btn-sm"
                        @click="deleteCourse(course.id)"
                ><i class="fas fa-trash"></i></button>
              </td>
              <td>
                <button class="btn btn-outline-dark btn-sm mr-1"
                        @click="changeState(course)"
                > {{ course.state==='draft' ? 'set as published' : 'set as draft'}}
                </button>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div v-if="showCreateCourseModal" class="modal fade show align-items-center">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create Course</h5>
            <button class="close" type="button" @click="showCreateCourseModal = false">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form class="user pt-3 px-3" @submit.prevent="createCourse">
              <div class="form-group">
                <label for="courseName">Course Name</label>
                <input
                  id="courseName"
                  class="form-control"
                  v-model="newCourse.name"
                  placeholder="Course Name"
                  required
                />
              </div>

              <div class="form-group">
                <label for="seoUrl">SEO URL</label>
                <input
                  id="seoUrl"
                  class="form-control"
                  v-model="newCourse.seo_url"
                  placeholder="SEO URL"
                  required
                />
              </div>

              <div class="form-group">
                <label for="faculty">Faculty</label>
                <select
                  id="faculty"
                  v-model="newCourse.faculty_id"
                  required
                  class="form-control"
                >
                  <option disabled hidden value="">Select Faculty</option>
                  <option v-for="faculty in faculties" :key="faculty.id" :value="faculty.id">
                    {{ faculty.name }}
                  </option>
                </select>
              </div>

              <div class="form-group">
                <label for="seoUrl">Credit</label>
                <input
                  id="seoUrl"
                  type="number"
                  class="form-control"
                  v-model="newCourse.credit"
                  placeholder="Credit"
                  required
                />
              </div>

              <div class="form-group" v-if="error">
                <span class="text-danger">{{ error }}</span>
              </div>
              <div class="modal-footer p-0 pt-3 mt-4">
                <button class="btn btn-secondary" @click="showCreateCourseModal = false">Cancel</button>
                <button class="btn btn-primary mr-0 ml-2" type="submit">Create</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div v-if="showUpdateCourseModal" class="modal fade show align-items-center">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update Course</h5>
            <button class="close" type="button" @click="showUpdateCourseModal = false">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form class="user pt-3 px-3" @submit.prevent="editCourse">
              <div class="form-group">
                <label for="courseName">Course Name</label>
                <input
                  id="courseName"
                  class="form-control"
                  v-model="selectedCourse.name"
                  placeholder="Course Name"
                  required
                />
              </div>

              <div class="form-group">
                <label for="seoUrl">SEO URL</label>
                <input
                  id="seoUrl"
                  class="form-control"
                  v-model="selectedCourse.seo_url"
                  placeholder="SEO URL"
                  required
                />
              </div>

              <div class="form-group">
                <label for="faculty">Faculty</label>
                <select
                  id="faculty"
                  v-model="selectedCourse.faculty_id"
                  required
                  class="form-control"
                >
                  <option disabled hidden value="">Select Faculty</option>
                  <option v-for="faculty in faculties" :key="faculty.id" :value="faculty.id">
                    {{ faculty.name }}
                  </option>
                </select>
              </div>

              <div class="form-group">
                <label for="seoUrl">Credit</label>
                <input
                  id="seoUrl"
                  type="number"
                  class="form-control"
                  v-model="selectedCourse.credit"
                  placeholder="Credit"
                  required
                />
              </div>

              <div class="form-group" v-if="error">
                <span class="text-danger">{{ error }}</span>
              </div>
              <div class="modal-footer p-0 pt-3 mt-4">
                <button class="btn btn-secondary" @click="showUpdateCourseModal = false">Cancel</button>
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
import axios from "@/axios.js";
import {mapGetters} from "vuex";

export default {
  data() {
    return {
      courses: [],
      newCourse: {
        name: '',
        seo_url: '',
        faculty_id: '',
        status: 'draft',
        credit: null,
      },
      selectedCourse: {},
      faculties: [],
      error: null,
      showCreateCourseModal: false,
      showUpdateCourseModal: false
    };
  },
  computed: {
    ...mapGetters(['hasPermission']),
    canCreateCourse() {
      return this.hasPermission('create course');
    },
    canViewCourse() {
      return this.hasPermission('view course');
    },
    canUpdateCourse() {
      return this.hasPermission('update course');
    },
    canDeleteCourse() {
      return this.hasPermission('delete course');
    },
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
    async fetchCourses() {
      try {
        const response = await axiosResources.fetchCourses(this.$store.state.role);
        this.courses = response.data;
      } catch (e) {
        console.log(e)
      }
    },
    async createCourse() {
      try {
        const response = await axiosResources.createCourse(this.$store.state.role, this.newCourse);
        this.showCreateCourseModal = false;
        this.error = null
        this.newCourse = {
          name: '',
          seo_url: '',
          faculty_id: '',
          status: 'draft',
          credit: null,
        }
        await this.fetchCourses();
      } catch (e) {
        this.error = e.response.data ? e.response.data.message : null
      }
    },
    async deleteCourse(courseId) {
      try {
        await axiosResources.deleteCourse(this.$store.state.role, courseId);
        await this.fetchCourses();
      } catch (e) {
        console.log(e)
      }
    },
    async editCourse() {
      try {
        const response = await axiosResources.updateCourse(this.$store.state.role, this.selectedCourse.id, this.selectedCourse);
        this.showUpdateCourseModal = false;
        this.error = null
        await this.fetchCourses();
      } catch (e) {
        this.error = e.response.data ? e.response.data.message : null
      }
    },
    async changeState(course) {
      try {
        await axiosResources.changeCourseState(this.$store.state.role, course.id, {
          state: course.state==='draft' ? 'published' : 'draft'
        });
        await this.fetchCourses();
      } catch (e) {
      }
    },
    openUpdateCourseModal(course) {
      this.selectedCourse = course
      this.showUpdateCourseModal = true
    }
  },
  mounted() {
    this.fetchCourses();
    this.fetchFaculties()
  }
};
</script>

<style scoped>
/* Add styles for modal and list */
</style>
