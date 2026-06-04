<script setup lang="ts">
definePageMeta({ layout: 'authentication' })

interface VerifyEmailResponse {
  success: boolean
  message?: string
}

const email = ref('')
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
  await $fetch('/sanctum/csrf-cookie', {
    baseURL: config.public.baseKey,
    credentials: 'include',
  })
}

const handleSubmit = async () => {
  errorMessage.value = ''

  if (!email.value) {
    errorMessage.value = 'Email harus diisi.'
    return
  }

  loading.value = true

  try {
    await fetchCsrfCookie()
    const xsrfToken = getCookie('XSRF-TOKEN')

    const response = await $fetch<VerifyEmailResponse>(
      `${config.public.apiKey}/landing-page/lupa-password/verify-email`,
      {
        method: 'POST',
        credentials: 'include',
        headers: {
          Accept: 'application/json',
          'Content-Type': 'application/json',
          ...(xsrfToken && { 'X-XSRF-TOKEN': decodeURIComponent(xsrfToken) })
        },
        body: { email: email.value }
      }
    )

    if (response.success) {
      localStorage.setItem('reset_email', email.value)
      router.push({
        path: '/autentikasi/verifyOtp',
        query: { email: email.value }
      })
    }
  } catch (error: any) {
    const status = error?.response?.status
    const data = error?.response?._data

    if (status === 419) {
      errorMessage.value = 'CSRF token tidak valid. Silakan muat ulang halaman.'
    } else if (status === 422) {
      errorMessage.value = data?.error || data?.message || 'Validasi gagal. Periksa input email.'
    } else if (status === 442) {
      errorMessage.value = data?.message || 'Email tidak terdaftar atau nomor WhatsApp kosong.'
    } else if (status === 500) {
      errorMessage.value = data?.error || data?.message || 'Gagal mengirim OTP ke WhatsApp. Coba lagi.'
    } else {
      errorMessage.value = data?.message || error?.message || 'Terjadi kesalahan yang tidak diketahui.'
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
            Lupa Kata Sandi?
          </span>
          <span class="leading-snug text-base tracking-tight font-normal text-ink-muted-dark">
            Cantumkan alamat email untuk verifikasi akun.
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
          <div>
            <button
              :disabled="loading"
              class="w-full font-medium py-2 tracking-tight rounded-sm cursor-pointer bg-flamingo-500 text-ink-base-light hover:bg-flamingo-600 transition-all duration-150 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed"
              type="submit">
              {{ loading ? 'Memproses...' : 'Verifikasi Email' }}
            </button>
          </div>
        </div>
        <div class="text-center tracking-tight">
          <span class="text-base font-normal text-ink-muted-dark">
            Ingat password anda?
            <NuxtLink
              class="font-medium text-ink-base-dark hover:underline underline-offset-2 transition-all duration-150 ease-in-out"
              to="/autentikasi/login">
              Kembali
            </NuxtLink>
          </span>
        </div>
        <!-- Hapus blok successMessage, hanya sisakan errorMessage -->
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
