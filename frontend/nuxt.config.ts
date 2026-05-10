export default defineNuxtConfig({
  compatibilityDate: "2025-05-15",

  // Modules
  modules: ["@nuxt/fonts", "@nuxt/image", "@nuxt/ui", "@nuxt/icon"],

  // Devtools
  devtools: { enabled: true },

  // Fonts
  fonts: {
    families: [
      { name: "DM Sans", provider: "google" },
      { name: "DM Mono", provider: "google" },
    ],
  },

  // UI
  css: [
    "./app/assets/css/main.css",
    "@fortawesome/fontawesome-svg-core/styles.css",
  ],
  features: {
    inlineStyles: true,
  },

  // Components
  components: [
    {
      path: "~/components",
      pathPrefix: false,
    },
  ],

  // Api
  runtimeConfig: {
    public: {
      apiKey: "",
      baseKey: "",
    },
  },
});
