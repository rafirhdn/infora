<script setup lang="ts">
  import type { NuxtError } from '#app'
  const props = defineProps<{ error: NuxtError }>()
</script>

<template>
  <div>
    <h1>{{ error.status }}</h1>
    <h3>{{ error.statusText }}</h3>
    <span v-if="error.data">{{ error.data }}</span>
  </div>
</template>
