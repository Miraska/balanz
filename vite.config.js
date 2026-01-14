import { defineConfig } from "vite";
import path from "path";

export default defineConfig({
  root: "./",
  base: "./",

  build: {
    outDir: "assets/dist",
    emptyOutDir: true,
    manifest: false,
    sourcemap: false,

    rollupOptions: {
      input: {
        main: path.resolve(__dirname, "assets/src/js/main.js"),
      },
      output: {
        entryFileNames: "js/[name].js",
        chunkFileNames: "js/[name].js",
        assetFileNames: (assetInfo) => {
          if (assetInfo.name.endsWith(".css")) {
            return "css/[name][extname]";
          }
          if (/\.(png|jpe?g|svg|gif|webp|avif)$/.test(assetInfo.name)) {
            return "images/[name][extname]";
          }
          if (/\.(woff2?|eot|ttf|otf)$/.test(assetInfo.name)) {
            return "fonts/[name][extname]";
          }
          return "assets/[name][extname]";
        },
      },
    },
  },

  css: {
    preprocessorOptions: {
      scss: {
        // Modern Sass API - no deprecation warnings
        api: 'modern-compiler',
        silenceDeprecations: ['legacy-js-api', 'import'],
      },
    },
  },

  server: {
    host: "localhost",
    port: 3000,
    open: false,
  },
});
