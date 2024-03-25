<script setup lang="ts">
  import { useUserStore } from '@/stores/user';
  import { useRouter } from 'vue-router';

  const userStore = useUserStore();
  const router = useRouter();

  if (!userStore.token) {
    const data = localStorage.getItem('pr24temp');
    if (data) {
      userStore.token = JSON.parse(data).token;
      userStore.user = JSON.parse(data).user;
    } else {
      localStorage.removeItem('pr24temp');
      router.push('/login');
    }
  }
</script>

<template>
  <div>
    <router-view></router-view>
  </div>
</template>
