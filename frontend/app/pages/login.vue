<script setup lang="ts"></script>

<template>
  <form @submit.prevent="">
    <div>
      <!-- Title -->
      <div>
        <span>Masuk ke Infora</span>
      </div>

      <!-- Input Box -->
      <div>
        <input type="email" placeholder="Masukkan email" />
      </div>

      <!-- Input Box -->
      <div>
        <input type="password" placeholder="Masukkan password" />
      </div>

      <!-- Button -->
      <div>
        <button type="submit">Masuk</button>
      </div>

      <!-- Link -->
      <div>
        <span>Lupa password anda?<NuxtLink>Klik di sini</NuxtLink></span>
      </div>

      <!-- Error -->
      <div>
        <div></div>
      </div>
    </div>
  </form>
</template>
