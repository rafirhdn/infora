export default defineNuxtConfig({
  compatibilityDate: "2025-05-15",

  // Modules
  modules: ["@nuxt/fonts", "@nuxt/image", "@nuxt/ui"],

  // Devtools
  devtools: { enabled: true },

  // Css
  css: [
    "./app/assets/css/main.css",
    "@fortawesome/fontawesome-svg-core/styles.css",
  ],
  features: {
    inlineStyles: true,
  },

  // Fonts
  fonts: {
    families: [
      { name: "DM Sans", provider: "google" },
      { name: "DM Mono", provider: "google" },
    ],
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
