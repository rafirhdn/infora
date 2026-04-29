export default defineNuxtConfig({
  ssr: true,
  compatibilityDate: "2025-05-15",
  modules: ["@nuxt/icon", "@nuxt/fonts", "@nuxt/image", "@nuxt/ui"],
  devtools: { enabled: true },
  css: ["./app/assets/css/main.css"],
  icon: {
    mode: "css",
    cssLayer: "base",
  },
  runtimeConfig: {
    public: {
      apiKey: "",
      baseKey: "",
    },
  },
});
