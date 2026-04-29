<script setup lang="ts"></script>

<template>
  <form @submit.prevent="">
    <div>
      <!-- Title -->
      <div>
        <span>Masukkan kode OTP anda</span>
      </div>

      <!-- Input Box -->
      <div>
        <input type="email" placeholder="Masukkan kode OTP" />
      </div>

      <!-- Button -->
      <div>
        <button type="submit">Verifikasi</button>
      </div>

      <!-- Error -->
      <div>
        <div></div>
      </div>
    </div>
  </form>
</template>
