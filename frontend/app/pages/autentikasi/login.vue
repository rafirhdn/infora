<script setup lang="ts">
definePageMeta({
  layout: 'authentication'
})

interface LoginResponse {
  success: boolean
  access_token?: string
  token_type?: string
  user?: any
  message?: string
}

const showPassword = ref(false)
const email = ref('')
const password = ref('')
const loading = ref(false)
const errorMessage = ref('')

const router = useRouter()
const config = useRuntimeConfig()

const getCookie = (name: string): string | null => {
  const value = `; ${document.cookie}`
  const parts = value.split(`; ${name}=`)
  if (parts.length === 2) return parts.pop()?.split(';').shift() || null
  return null
}

const fetchCsrfCookie = async () => {
  try {
    await $fetch('/sanctum/csrf-cookie', {
      baseURL: 'http://localhost:8000',
      credentials: 'include',
    })
  } catch (error) {
    console.error('Gagal mengambil CSRF cookie:', error)
    throw new Error('Tidak dapat memulai sesi keamanan')
  }
}

const handleSubmit = async () => {
  errorMessage.value = ''

  if (!email.value || !password.value) {
    errorMessage.value = 'Email dan kata sandi harus diisi.'
    return
  }

  loading.value = true

  try {
    await fetchCsrfCookie()

    const xsrfToken = getCookie('XSRF-TOKEN')

    // FIX: useFetch → $fetch, dan decodeURIComponent pada xsrfToken
    const response = await $fetch<LoginResponse>('/landing-page/login', {
      baseURL: config.public.apiKey,
      method: 'POST',
      credentials: 'include',
      headers: {
        ...(xsrfToken && { 'X-XSRF-TOKEN': decodeURIComponent(xsrfToken) })
      },
      body: {
        email: email.value,
        kata_sandi: password.value
      }
    })

    if (response?.success && response.access_token) {
      localStorage.setItem('access_token', response.access_token)
      localStorage.setItem('token_type', response.token_type || 'Bearer')
      localStorage.setItem('user', JSON.stringify(response.user))
      await router.push('/halamanLanding/home')
    } else {
      errorMessage.value = response?.message || 'Login gagal'
    }
  } catch (err: any) {
    const status = err?.response?.status
    const message = err?.response?._data?.message

    if (status === 419) {
      errorMessage.value = 'CSRF token tidak valid. Silakan muat ulang halaman.'
    } else if (status === 421) {
      errorMessage.value = message || 'Email atau kata sandi salah.'
    } else if (status === 422) {
      errorMessage.value = message || 'Validasi gagal. Periksa input anda.'
    } else {
      errorMessage.value = message || err.message || 'Terjadi kesalahan pada sistem'
    }
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div class="w-screen h-screen font-sans flex flex-row">
    <form
      @submit.prevent="handleSubmit"
      class="w-full bg-surface-canvas flex items-center justify-center">
      <div class="flex flex-col gap-6 w-full max-w-sm">
        <div class="flex flex-col gap-1.5 text-center">
          <span class="text-2xl tracking-tight font-medium text-ink-base-dark">
            Selamat Datang!
          </span>
          <span class="leading-snug text-base tracking-tight font-normal text-ink-muted-dark">
            Akses sistem manajemen dan lanjutkan aktivitas.
          </span>
        </div>
        <div class="flex flex-col gap-4">
          <div>
            <input
              v-model="email"
              class="w-full px-3.5 py-1.5 tracking-tight outline-none border-2 border-line-faint rounded-sm text-ink-base-dark placeholder:text-ink-muted-dark hover:bg-canvas-hover hover:border-flamingo-500 focus:border-flamingo-500 focus:bg-surface-canvas transition-all duration-150 ease-in-out"
              type="email"
              placeholder="Email" />
          </div>
          <div class="relative">
            <input
              v-model="password"
              class="w-full px-3.5 py-1.5 pr-10 tracking-tight outline-none border-2 border-line-faint rounded-sm text-base text-ink-base-dark placeholder:text-ink-muted-dark hover:bg-canvas-hover hover:border-flamingo-500 focus:border-flamingo-500 focus:bg-surface-canvas transition-all duration-150 ease-in-out"
              :type="showPassword ? 'text' : 'password'"
              placeholder="Kata Sandi" />
            <Icon
              :name="showPassword ? 'hugeicons:view' : 'hugeicons:view-off'"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-ink-muted-dark w-6 h-6 cursor-pointer"
              @click="showPassword = !showPassword" />
          </div>
          <div>
            <button
              :disabled="loading"
              class="w-full font-medium py-2 tracking-tight rounded-sm cursor-pointer bg-flamingo-500 text-ink-base-light hover:bg-flamingo-600 transition-all duration-150 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed"
              type="submit">
              {{ loading ? 'Memproses...' : 'Masuk' }}
            </button>
          </div>
        </div>
        <div class="text-center tracking-tight">
          <span class="text-base font-normal text-ink-muted-dark">
            Lupa password anda?
            <NuxtLink
              class="font-medium text-ink-base-dark hover:underline underline-offset-2 transition-all duration-150 ease-in-out"
              to="/autentikasi/verifyEmail">
              Klik di sini
            </NuxtLink>
          </span>
        </div>
        <div
          v-if="errorMessage"
          class="flex flex-row items-start gap-2.5 px-3.5 py-2.5 bg-red-50 border border-red-300 rounded-sm">
          <span class="font-mono text-[13px] leading-relaxed text-red-800">
            {{ errorMessage }}
          </span>
        </div>
      </div>
    </form>
  </div>
</template>
