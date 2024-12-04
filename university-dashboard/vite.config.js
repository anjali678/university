import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueDevTools from 'vite-plugin-vue-devtools'

// https://vite.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    vueDevTools(),
  ],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    },
  },
  server: {
    port: 3000, // Set the Vue app to run on port 3000
    proxy: {
      '/api': {
        target: 'http://localhost:8000', // Target Laravel API (running on port 8000)
        changeOrigin: true,
        secure: false,
      },
    },
  },
  define: {
    'process.env': process.env,
  },
  css: {
    preprocessorOptions: {
      scss: {
        // Include any global variables or mixins you want to be available in every component
        additionalData: `@import "@/assets/scss/_variables.scss";`
      },
    },
  },
})
