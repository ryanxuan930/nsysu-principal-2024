import { ref } from 'vue';
import type { Ref } from 'vue';
import { defineStore } from 'pinia';

export const useUserStore: any = defineStore('user', () => {
  const user: Ref<any> = ref({});
  const token: Ref<string> = ref('');
  function reset() {
    user.value = {};
    token.value = '';
  }
  return { user, token, reset };
});
