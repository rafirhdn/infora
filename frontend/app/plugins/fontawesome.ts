// plugins/fontawesome.ts
import { defineNuxtPlugin } from '#app'
import { library, config } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { far } from '@fortawesome/free-regular-svg-icons'

// Matikan auto-add CSS karena sudah di-load manual di nuxt.config.ts
config.autoAddCss = false

// Daftarkan SEMUA icon sekaligus (lebih simpel & aman untuk v7)
library.add(fas, far)

export default defineNuxtPlugin((nuxtApp) => {
  nuxtApp.vueApp.component('font-awesome-icon', FontAwesomeIcon)
})