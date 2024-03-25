<script setup lang="ts">
  import Button from 'primevue/button';
  import { useRouter } from 'vue-router';

  const router = useRouter();
</script>

<template>
  <div class="p-10 lg:flex">
    <div class="w-full lg:w-1/3 m-auto">
      <Button class="button" label="掃碼" @click="router.push('/admin/scan')" />
      <Button class="button" label="座位圖" @click="router.push('/admin/seat')" />
      <Button class="button" label="報名系統" @click="router.push('/admin/registration')" />
    </div>
  </div>
</template>

<style scoped lang="scss">
  .button {
    @apply p-2 w-full mb-3 bg-black text-white rounded-md;
  }
</style>
