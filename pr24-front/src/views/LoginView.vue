<script setup lang="ts">
  import { ref } from 'vue';
  import { useRouter } from 'vue-router';
  import VueRequest from '@/vue-request';
  import InputText from 'primevue/inputtext';
  import Password from 'primevue/password';
  import Button from 'primevue/button';
  import { useUserStore } from '@/stores/user';

  const router = useRouter();
  const vr = new VueRequest();
  const userStore = useUserStore();

  const form = ref({
    account: '',
    password: '',
  });

  function login() {
    vr.Post('auth/login', form.value).then((res) => {
      if (res.message === 'OK') {
        localStorage.setItem('pr24temp', JSON.stringify({ token: res.token, user: res.user }));
        userStore.user = res.user;
        userStore.token = res.token;
        router.push('/admin');
      }
    });
  }
</script>

<template>
  <div class="flex bg-white">
    <div class="hidden sm:block flex-grow"></div>
    <div class="h-screen flex flex-col w-full sm:w-96 p-5 sm:p-0">
      <div class="flex-grow"></div>
      <div class="border rounded p-5">
        <div class="text-2xl font-semibold">票務管理系統</div>
        <hr class="my-5" />
        <div>
          <InputText class="block input" v-model="form.account" placeholder="帳號" />
          <Password class="block input" v-model="form.password" placeholder="密碼" />
          <Button class="block button" @click="login" label="登入" />
        </div>
      </div>
      <div class="flex-grow"></div>
    </div>
    <div class="hidden sm:block flex-grow"></div>
  </div>
</template>

<style scoped lang="scss">
  .input {
    @apply p-2 w-full mb-3 border border-gray-300 rounded-md;
  }
  .button {
    @apply p-2 w-full mb-3 bg-black text-white rounded-md;
  }
</style>
