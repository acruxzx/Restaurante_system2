import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
  plugins: [vue()],
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'resources/js'),
    },
  },
  server: {
    port: 3000,
    watch: {
      usePolling: true,
    },
  },
  build: {
    rollupOptions: {
      input: path.resolve(__dirname, 'resources/js/app.js'),
    },
  },
  optimizeDeps: {
    include: ['vue', '@vitejs/plugin-vue', '@fortawesome/fontawesome-free'],
  },
});
