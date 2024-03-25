<script setup lang="ts">
  import { ref, onMounted, onBeforeUnmount } from 'vue';
  import { useUserStore } from '@/stores/user';
  import VueRequest from '@/vue-request';

  const userStore = useUserStore();
  const vr = new VueRequest(userStore.token);

  const seats = ref([]);

  function getData() {
    vr.Get('seat-order', null, true, true).then((res) => {
      seats.value = res.reverse();
    });
  }
  getData();
</script>

<template>
  <div></div>
</template>

<style scoped lang="scss"></style>
