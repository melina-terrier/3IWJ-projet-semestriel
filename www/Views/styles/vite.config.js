import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
  plugins: [vue()],
  css: {
    preprocessorOptions: {
      scss: {
        additionalData: `@import "src/css/partials/_variables.scss"; @import "src/css/partials/_mixins.scss";`
      }
    }
  }
});
