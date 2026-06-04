<script setup lang="ts">
definePageMeta({ layout: 'authentication' })

interface ResetPasswordResponse {
  success: boolean
  message?: string
}

const newPassword = ref('')
const confirmPassword = ref('')
const showNewPassword = ref(false)
const showConfirmPassword = ref(false)
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

  if (!newPassword.value) {
    errorMessage.value = 'Kata sandi baru harus diisi.'
    return
  }
  if (newPassword.value.length < 8) {
    errorMessage.value = 'Kata sandi minimal 8 karakter.'
    return
  }
  if (newPassword.value !== confirmPassword.value) {
    errorMessage.value = 'Konfirmasi kata sandi tidak cocok.'
    return
  }

  loading.value = true

  try {
    await fetchCsrfCookie()
    const xsrfToken = getCookie('XSRF-TOKEN')

    const response = await $fetch<ResetPasswordResponse>(
      `${config.public.apiKey}/landing-page/lupa-password/reset-password`,
      {
        method: 'POST',
        credentials: 'include',
        headers: {
          Accept: 'application/json',
          'Content-Type': 'application/json',
          ...(xsrfToken && { 'X-XSRF-TOKEN': decodeURIComponent(xsrfToken) })
        },
        body: {
          email,
          kata_sandi_baru: newPassword.value,
          kata_sandi_baru_confirmation: confirmPassword.value
        }
      }
    )

    if (response.success) {
      localStorage.removeItem('reset_email')
      router.push('/autentikasi/login')
    }
  } catch (error: any) {
    const status = error?.response?.status
    const data = error?.response?._data

    if (status === 419) {
      errorMessage.value = 'CSRF token tidak valid. Silakan muat ulang halaman.'
    } else if (status === 403) {
      errorMessage.value = 'Sesi OTP sudah habis. Silakan ulangi dari awal.'
    } else if (status === 404) {
      errorMessage.value = 'Akun tidak ditemukan.'
    } else if (status === 422) {
      errorMessage.value = data?.error || data?.message || 'Validasi gagal. Periksa kembali input anda.'
    } else if (status === 500) {
      errorMessage.value = 'Terjadi kesalahan server. Periksa log Laravel.'
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
            Buat Kata Sandi Baru
          </span>
          <span class="leading-snug text-base tracking-tight font-normal text-ink-muted-dark">
            Masukkan kata sandi baru untuk akun anda.
          </span>
        </div>
        <div class="flex flex-col gap-4">
          <div class="relative">
            <input
              v-model="newPassword"
              class="w-full px-3.5 py-1.5 pr-10 tracking-tight outline-none border-2 border-line-faint rounded-sm text-ink-base-dark placeholder:text-ink-muted-dark hover:bg-canvas-hover hover:border-flamingo-500 focus:border-flamingo-500 focus:bg-surface-canvas transition-all duration-150 ease-in-out"
              :type="showNewPassword ? 'text' : 'password'"
              placeholder="Kata Sandi Baru" />
            <Icon
              :name="showNewPassword ? 'hugeicons:view' : 'hugeicons:view-off'"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-ink-muted-dark w-6 h-6 cursor-pointer"
              @click="showNewPassword = !showNewPassword" />
          </div>
          <div class="relative">
            <input
              v-model="confirmPassword"
              class="w-full px-3.5 py-1.5 pr-10 tracking-tight outline-none border-2 border-line-faint rounded-sm text-ink-base-dark placeholder:text-ink-muted-dark hover:bg-canvas-hover hover:border-flamingo-500 focus:border-flamingo-500 focus:bg-surface-canvas transition-all duration-150 ease-in-out"
              :type="showConfirmPassword ? 'text' : 'password'"
              placeholder="Konfirmasi Kata Sandi" />
            <Icon
              :name="showConfirmPassword ? 'hugeicons:view' : 'hugeicons:view-off'"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-ink-muted-dark w-6 h-6 cursor-pointer"
              @click="showConfirmPassword = !showConfirmPassword" />
          </div>
          <div>
            <button
              :disabled="loading"
              class="w-full font-medium py-2 tracking-tight rounded-sm cursor-pointer bg-flamingo-500 text-ink-base-light hover:bg-flamingo-600 transition-all duration-150 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed"
              type="submit">
              {{ loading ? 'Memproses...' : 'Simpan Kata Sandi' }}
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
