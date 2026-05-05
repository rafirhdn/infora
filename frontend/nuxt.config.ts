export default defineNuxtConfig({
  ssr: true,
  compatibilityDate: "2025-05-15",
  modules: ["@nuxt/fonts", "@nuxt/image", "@nuxt/ui"],
  devtools: { enabled: true },
  css: [
    "./app/assets/css/main.css",
    '@fortawesome/fontawesome-svg-core/styles.css'
  ],
  
  // Tambahkan konfigurasi untuk layout
  components: [
    {
      path: '~/components',
      pathPrefix: false,
    },
  ],
  
  // Pastikan layout terdeteksi
  features: {
    inlineStyles: true,
  },
  
  runtimeConfig: {
    public: {
      apiKey: "",
      baseKey: "",
    },
  },
  
  // Konfigurasi nitro untuk development
  nitro: {
    devProxy: {
      '/api': {
        target: 'http://localhost:3001', // Sesuaikan dengan backend Anda
        changeOrigin: true,
      }
    }
  }
})