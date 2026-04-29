<script setup lang="ts"></script>

<template>
  <form @submit.prevent="">
    <div>
      <!-- Title -->
      <div>
        <span>Perbarui password anda</span>
      </div>

      <!-- Input Box -->
      <div>
        <input type="password" placeholder="Masukkan password baru" />
      </div>

      <!-- Input Box -->
      <div>
        <input type="password" placeholder="Masukkan ulang password baru" />
      </div>

      <!-- Button -->
      <div>
        <button type="submit">Perbarui</button>
      </div>

      <!-- Error -->
      <div>
        <div></div>
      </div>
    </div>
  </form>
</template>
