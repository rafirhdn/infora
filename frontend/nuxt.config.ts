import tailwindcss from "@tailwindcss/vite";

export default defineNuxtConfig({
  compatibilityDate: "2025-07-15",
  modules: ["@nuxt/icon", "@nuxt/fonts", "@nuxt/image", "@nuxt/ui"],
  devtools: { enabled: true },
  css: ["./app/assets/css/main.css"],
  vite: {
    plugins: [tailwindcss()],
  },
  icon: {
    mode: "css",
    cssLayer: "base",
  },
  runtimeConfig: {
      public: {
         apiKey: '',
         baseKey: '',
      },
   },
});
