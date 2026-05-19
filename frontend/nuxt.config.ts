export default defineNuxtConfig({
  compatibilityDate: "2025-05-15",

  modules: [
    "@nuxt/fonts",
    "@nuxt/image",
    "@nuxt/ui",
    "@nuxt/icon",
  ],

  devtools: {
    enabled: true,
  },

  fonts: {
    families: [
      { name: "DM Sans", provider: "google" },
      { name: "DM Mono", provider: "google" },
    ],
  },

  css: [
    "./app/assets/css/main.css",
    "@fortawesome/fontawesome-svg-core/styles.css",
  ],

  features: {
    inlineStyles: true,
  },

  components: [
    {
      path: "~/components",
      pathPrefix: false,
    },
  ],

  runtimeConfig: {
    public: {
      apiKey: import.meta.env.NUXT_PUBLIC_API_KEY,
      baseKey: import.meta.env.NUXT_PUBLIC_BASE_KEY,
    },
  },
});