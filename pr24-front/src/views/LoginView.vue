<script setup lang="ts">
  import { ref } from 'vue';
  import { useRouter } from 'vue-router';
  import VueRequest from '@/vue-request';

  const router = useRouter();
  const vr = new VueRequest();

  const form = ref({
    account: '',
    password: '',
  });

  function login() {
    vr.Post('auth/login', form.value).then((res) => {
      if (res.status === 200) {
        localStorage.setItem('pr24temp', res.data.token);
        router.push('/');
      }
    });
  }
</script>

<template>
  <div class="bg-class">
    <div style="background-color: white; padding: 20px">
      <h1>Login</h1>
      <div>
        <input v-model="form.account" type="text" placeholder="Account" />
        <input v-model="form.password" type="password" placeholder="Password" />
        <button @click="login">Login</button>
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
  .bg-class {
    background-color: #f0f0f0;
    height: 100vh;
    display: flex;
    justify-content: center;
    padding: 10%;
  }
  input,
  button {
    display: block;
    margin: 10px 0;
    width: 300px;
    padding: 10px;
  }
</style>
