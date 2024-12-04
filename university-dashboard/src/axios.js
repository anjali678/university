import axios from 'axios';

// Fetch CSRF token and make login request
await axios.get('/sanctum/csrf-cookie');
const axiosInstance = axios.create({
  baseURL: import.meta.env.VITE_API_URL, // Use your API URL here
  withCredentials: true, // Important for Sanctum authentication
});
// Function to get CSRF token from cookies
const getCsrfToken = () => {
  const csrfToken = document.cookie.split('; ').find((row) => row.startsWith('XSRF-TOKEN='))?.split('=')[1];
  return csrfToken ? decodeURIComponent(csrfToken) : '';
};

// Set the authorization token for every request
axiosInstance.interceptors.request.use(
  (config) => {
    const csrfToken = getCsrfToken();
    if (csrfToken) {
      config.headers['X-XSRF-TOKEN'] = csrfToken; // Add CSRF token header
    }

    return config;
  },
  (error) => Promise.reject(error)
);

// Handle responses
axiosInstance.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response.status === 401) {
      window.location.href = '/login';
    }
    return Promise.reject(error);
  }
);

const getRoleBasedAPI = (role) => {
  switch (role) {
    case 'Admin':
      return '/admin';
    case 'Teacher':
      return '/teacher';
    case 'Academic Head':
      return '/academic-head';
    case 'Student':
      return '/student';
    default:
      return '/'; // Default route (for unassigned roles)
  }
};

// Axios methods for Courses, Modules, and Syllabus
export const axiosResources = {
  // Courses
  fetchCourses: (role) => {
    return axiosInstance.get(`/api${getRoleBasedAPI(role)}/courses`);
  },
  createCourse: (role, courseData) => {
    return axiosInstance.post(`/api${getRoleBasedAPI(role)}/courses`, courseData);
  },
  updateCourse: (role, courseId, courseData) => {
    return axiosInstance.put(`/api${getRoleBasedAPI(role)}/courses/${courseId}`, courseData);
  },
  deleteCourse: (role, courseId) => {
    return axiosInstance.delete(`/api${getRoleBasedAPI(role)}/courses/${courseId}`);
  },
  changeCourseState: (role, courseId, courseData) => {
    return axiosInstance.post(`/api${getRoleBasedAPI(role)}/courses/${courseId}/state`, courseData);
  },

  // Modules
  fetchModules: (role) => {
    return axiosInstance.get(`/api${getRoleBasedAPI(role)}/modules`);
  },
  createModule: (role, moduleData) => {
    return axiosInstance.post(`/api${getRoleBasedAPI(role)}/modules`, moduleData);
  },
  updateModule: (role, moduleId, moduleData) => {
    return axiosInstance.put(`/api${getRoleBasedAPI(role)}/modules/${moduleId}`, moduleData);
  },
  deleteModule: (role, moduleId) => {
    return axiosInstance.delete(`/api${getRoleBasedAPI(role)}/modules/${moduleId}`);
  },
  changeModuleState: (role, moduleId, moduleData) => {
    return axiosInstance.post(`/api${getRoleBasedAPI(role)}/modules/${moduleId}/state`, moduleData);
  },

  // Syllabus
  fetchSyllabus: (role) => {
    return axiosInstance.get(`/api${getRoleBasedAPI(role)}/syllabuses`);
  },
  createSyllabus: (role, syllabusData) => {
    return axiosInstance.post(`/api${getRoleBasedAPI(role)}/syllabuses`, syllabusData);
  },
  updateSyllabus: (role, syllabusId, syllabusData) => {
    return axiosInstance.put(`/api${getRoleBasedAPI(role)}/syllabuses/${syllabusId}`, syllabusData);
  },
  deleteSyllabus: (role, syllabusId) => {
    return axiosInstance.delete(`/api${getRoleBasedAPI(role)}/syllabuses/${syllabusId}`);
  },
  changeSyllabusState: (role, syllabusId, syllabusData) => {
    return axiosInstance.post(`/api${getRoleBasedAPI(role)}/syllabuses/${syllabusId}/state`, syllabusData);
  },
}

export default axiosInstance;
