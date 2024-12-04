import { createStore } from 'vuex';
import axios from '../axios';

const store = createStore({
  state: {
    user: null,
    role: null,
    permissions: [],
  },
  mutations: {
    setUser(state, userData) {
      state.user = userData.user;
      state.role = userData.role
      state.permissions = userData.permissions
    },
    clearUser(state) {
      state.user = null;
      state.role = null;
      state.permissions = [];
    },
  },
  actions: {
    // Action to fetch user from /api/user endpoint
    async fetchUser({ commit }) {
      try {
        const response = await axios.get('/api/user');
        commit('setUser', response.data); // Set user data in Vuex state
      } catch (err) {
        commit('clearUser'); // If authentication fails, clear user
      }
    },
    // Action to log out the user
    async logout({ commit }) {
      try {
        await axios.post('/logout');
        commit('clearUser'); // Clear user on logout
      } catch (err) {
        console.error(err);
      }
    },
  },
  getters: {
    hasPermission: (state) => (permission) => {
      return state.permissions.includes(permission);
    },
    hasRole: (state) => (role) => {
      return state.role === role;
    },
  },
});

export default store;
