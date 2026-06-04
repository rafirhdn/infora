<script setup lang="ts">
definePageMeta({ layout: 'authentication' })

interface VerifyOtpResponse {
  success: boolean
  message?: string
}

const otp = ref('')
const loading = ref(false)
const errorMessage = ref('')

const router = useRouter()
const route = useRoute()
const config = useRuntimeConfig()

const email = (
  (route.query.email as string) ||
  localStorage.getItem('reset_email') ||
  ''
).trim()

onMounted(() => {
  if (!email) {
    router.push('/autentikasi/verifyEmail')
  }
})

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

  if (!otp.value) {
    errorMessage.value = 'Kode OTP harus diisi.'
    return
  }

  if (otp.value.length !== 6) {
    errorMessage.value = 'Kode OTP harus 6 digit.'
    return
  }

  loading.value = true

  try {
    await fetchCsrfCookie()
    const xsrfToken = getCookie('XSRF-TOKEN')

    const response = await $fetch<VerifyOtpResponse>(
      `${config.public.apiKey}/landing-page/lupa-password/verify-otp`,
      {
        method: 'POST',
        credentials: 'include',
        headers: {
          Accept: 'application/json',
          'Content-Type': 'application/json',
          ...(xsrfToken && { 'X-XSRF-TOKEN': decodeURIComponent(xsrfToken) })
        },
        body: { email, otp: otp.value }
      }
    )

    if (response.success) {
      router.push({
        path: '/autentikasi/newPassword',
        query: { email }
      })
    }
  } catch (error: any) {
    const status = error?.response?.status
    const data = error?.response?._data

    if (status === 419) {
      errorMessage.value = 'CSRF token tidak valid. Silakan muat ulang halaman.'
    } else if (status === 422) {
      errorMessage.value = data?.error || data?.message || 'Kode OTP salah atau sudah kadaluarsa.'
    } else {
      errorMessage.value = data?.message || error?.message || 'Terjadi kesalahan. Silakan coba lagi.'
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
            Verifikasi Alamat Email!
          </span>
          <span class="leading-snug text-base tracking-tight font-normal text-ink-muted-dark">
            Cantumkan kode OTP yang telah dikirimkan.
          </span>
        </div>
        <div class="flex flex-col gap-4">
          <div>
            <input
              v-model="otp"
              class="w-full px-3.5 py-1.5 tracking-tight outline-none border-2 border-line-faint rounded-sm text-ink-base-dark placeholder:text-ink-muted-dark hover:bg-canvas-hover hover:border-flamingo-500 focus:border-flamingo-500 focus:bg-surface-canvas transition-all duration-150 ease-in-out"
              type="text"
              maxlength="6"
              placeholder="Kode OTP" />
          </div>
          <div>
            <button
              :disabled="loading"
              class="w-full font-medium py-2 tracking-tight rounded-sm cursor-pointer bg-flamingo-500 text-ink-base-light hover:bg-flamingo-600 transition-all duration-150 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed"
              type="submit">
              {{ loading ? 'Memproses...' : 'Verifikasi' }}
            </button>
          </div>
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
