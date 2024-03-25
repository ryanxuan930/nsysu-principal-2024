<script setup lang="ts">
  import { ref } from 'vue';
  import { useUserStore } from '@/stores/user';
  import VueRequest from '@/vue-request';
  import { QrcodeStream } from 'vue-qrcode-reader';

  const userStore = useUserStore();
  const vr = new VueRequest(userStore.token);
  const isPaused = ref(false);
  const userData: any = ref({});
  const seatData: any = ref({});

  async function initialize(promise: any) {
    try {
      const { capabilities } = await promise;
    } catch (error: any) {
      if (error.name === 'NotAllowedError') {
        alert('請允許使用鏡頭');
      } else if (error.name === 'NotFoundError') {
        alert('找不到鏡頭');
      } else if (error.name === 'NotSupportedError') {
        alert('不支援本功能');
      } else if (error.name === 'NotReadableError') {
        alert('無法讀取');
      } else if (error.name === 'OverconstrainedError') {
        alert('無法滿足需求');
      } else if (error.name === 'StreamApiNotSupportedError') {
        alert('不支援本功能');
      } else if (error.name === 'TrackStartError') {
        alert('無法啟動鏡頭');
      } else {
        alert('無法啟動鏡頭');
      }
    } finally {
      // hide loading indicator
    }
  }

  async function codeHandler(code: any) {
    isPaused.value = true;
    userData.value = {};
    const res = await vr.Post('auth/decode', { payload: code[0].rawValue }, null, true, true);
    if (res.message === 'OK') {
      userData.value = res.user;
      seatData.value = res.seat;
    } else if (res.message === 'error') {
      alert('QR Code 錯誤');
    } else {
      alert('驗證失敗');
    }
    isPaused.value = false;
  }

  function paintOutline(detectedCodes: any, ctx: any) {
    for (const detectedCode of detectedCodes) {
      const [firstPoint, ...otherPoints] = detectedCode.cornerPoints;

      ctx.strokeStyle = 'red';

      ctx.beginPath();
      ctx.moveTo(firstPoint.x, firstPoint.y);
      for (const { x, y } of otherPoints) {
        ctx.lineTo(x, y);
      }
      ctx.lineTo(firstPoint.x, firstPoint.y);
      ctx.closePath();
      ctx.stroke();
    }
  }
</script>

<template>
  <div class="w-full sm:m-auto sm:w-1/3 p-5 flex flex-col gap-5">
    <router-link to="/admin">回上頁</router-link>
    <hr />
    <div class="text-2xl">掃描QR Code</div>
    <div>
      <QrcodeStream @init="initialize" @detect="codeHandler" :paused="isPaused" :track="paintOutline">
        <div class="h-full w-full flex flex-col bg-white bg-opacity-80" v-if="isPaused">
          <div class="flex-grow"></div>
          <div class="text-center text-2xl">讀取中...</div>
          <div class="flex-grow"></div>
        </div>
      </QrcodeStream>
      <hr class="my-2" />
      <div class="text-2xl font-semibold flex flex-col gap-3" v-if="seatData.area !== undefined">
        <div>姓名：{{ userData.name }}</div>
        <div>學號：{{ userData.student_no }}</div>
        <div>座位：{{ seatData.area }} 區 {{ seatData.row }} 排 {{ seatData.no }} 號</div>
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss"></style>
