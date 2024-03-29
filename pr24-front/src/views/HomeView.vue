<script setup lang="ts">
  import { ref, onMounted, onBeforeUnmount } from 'vue';
  import type { Ref } from 'vue';
  import VueQrcode from '@chenfengyuan/vue-qrcode';
  import VueRequest from '@/vue-request';
  import InputText from 'primevue/inputtext';
  import Button from 'primevue/button';
  import QuestionView from '@/views/QuestionView.vue';

  const vr = new VueRequest();

  const userData: any = ref(null);
  const form = ref({
    email: '',
    student_no: '',
  });

  if (localStorage.getItem('pr24student')) {
    userData.value = JSON.parse(localStorage.getItem('pr24student') as string);
  }

  function login() {
    if (!form.value.email || !form.value.student_no) {
      alert('請輸入所有欄位');
      return;
    }
    form.value.student_no = form.value.student_no.toUpperCase();
    vr.Post('student-login', form.value).then((res) => {
      if (res.message === 'OK') {
        userData.value = res;
        localStorage.setItem('pr24student', JSON.stringify(res));
      } else {
        alert(res.message);
      }
    });
  }

  function logout() {
    localStorage.removeItem('pr24student');
    userData.value = null;
  }

  const signoutStatus = ref(false);
  function getSignoutStatus() {
    const now = new Date();
    if (now.getFullYear() === 2024 && now.getMonth() === 2 && now.getDate() === 25 && now.getHours() >= 21 && now.getHours() <= 23) {
      signoutStatus.value = true;
    }
  }
  getSignoutStatus();

  let invervalContext: any = null;
  onMounted(() => {
    invervalContext = setInterval(() => {
      if (userData.value) {
        vr.Get(`student/${userData.value.student.student_id}`, null, true, true).then((res) => {
          userData.value.student = res;
          localStorage.setItem('pr24student', JSON.stringify(userData.value));
        });
      }
      getSignoutStatus();
    }, 10000);
  });
  onBeforeUnmount(() => {
    clearInterval(invervalContext);
  });
</script>

<template>
  <div class="w-full h-screen bg-gray-50 lg:flex p-5 lg:p-0">
    <div class="w-full lg:w-1/3 m-auto bg-white p-5 shadow">
      <div>
        <img src="@/assets/logo.svg" alt="" />
      </div>
      <!-- Login -->
      <div v-if="!userData">
        <div>
          <InputText class="block input" v-model="form.email" placeholder="Email" />
          <InputText class="block input" v-model="form.student_no" placeholder="學號" />
          <Button class="block button" @click="login" label="登入" />
        </div>
      </div>
      <div v-else>
        <template v-if="!signoutStatus">
          <div class="text-xl text-center font-semibold">請於入口處出示本條碼</div>
          <div class="flex b-0 m-0 p-0">
            <div class="flex-grow"></div>
            <vue-qrcode :value="userData.payload" tag="svg" :options="{ errorCorrectionLevel: 'H', width: 350 }"></vue-qrcode>
            <div class="flex-grow"></div>
          </div>
          <div class="text-2xl font-semibold text-center">
            您的座位：
            <span v-if="userData.student.area == '0'">掃碼通關後顯示</span>
            <span v-else>{{ userData.student.area }} 區 {{ userData.student.row }} 排 {{ userData.student.no }} 號</span>
          </div>
        </template>
        <hr />
        <QuestionView :userData="userData" v-if="signoutStatus" @logout="logout" />
        <hr />
        <Button class="block button" @click="logout" label="登出" />
        <div class="p-5"></div>
      </div>
    </div>
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
