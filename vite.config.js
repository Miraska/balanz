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
          // SCSS/CSS файлы в папку css
          if (assetInfo.name.endsWith(".css")) {
            return "css/[name][extname]";
          }
          // Изображения в папку images
          if (/\.(png|jpe?g|svg|gif|webp|avif)$/.test(assetInfo.name)) {
            return "images/[name][extname]";
          }
          // Шрифты в папку fonts
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
        additionalData: `@import "./assets/src/scss/abstracts/_variables.scss";`,
      },
    },
    postcss: {
      plugins: [require("autoprefixer")],
    },
  },

  server: {
    host: "localhost",
    port: 3000,
    open: false,
  },
});
