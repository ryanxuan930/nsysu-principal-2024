<script setup lang="ts">
  import { ref } from 'vue';
  import VueRequest from '@/vue-request';
  import RadioButton from 'primevue/radiobutton';
  import InputText from 'primevue/inputtext';
  import Dropdown from 'primevue/dropdown';
  import Rating from 'primevue/rating';
  import Textarea from 'primevue/textarea';
  import router from '@/router';

  const vr = new VueRequest();
  const props = defineProps(['userData']);
  const form = ref({
    identity: '學生',
    college: '文學院',
    grade: '大學部',
    q1_score: 0,
    q1_comment: '',
    q2_score: 0,
    q2_comment: '',
    q3_comment: '',
    q4_score: 0,
    q4_comment: '',
    q5_comment: '',
    q6_comment: '',
  });
  const identity = ref('');
  const college = ref('');
  const grade = ref('');

  const collegeList = ['文學院', '理學院', '工學院', '社會科學院', '管理學院', '海洋科學院', '醫學院', '西灣學院', '半導體研究學院', '國際金融研究學院', '其他'];

  function submit() {
    if (form.value.q1_score === 0 || form.value.q2_score === 0 || form.value.q4_score === 0) {
      alert('請完整填寫問卷');
      return;
    }
    if (form.value.q1_comment === '' || form.value.q2_comment === '' || form.value.q3_comment === '' || form.value.q4_comment === '' || form.value.q5_comment === '' || form.value.q6_comment === '') {
      alert('請完整填寫問卷');
      return;
    }

    if (form.value.identity === '其他') {
      form.value.identity = identity.value;
    }
    if (form.value.college === '其他') {
      form.value.college = college.value;
    }
    if (form.value.grade === '其他') {
      form.value.grade = grade.value;
    }
    vr.Post('feedback', form.value).then((res) => {
      if (res.message === 'OK') {
        alert('問卷填寫成功，感謝您的參與，祝您有個美好的夜晚');
      }
    });
  }
</script>

<template>
  <div class="w-full p-3 shadow-inner my-5 bg-gray-100">
    <div class="title">身份別</div>
    <div class="flex flex-wrap gap-3 flex-col">
      <div class="flex align-items-center">
        <RadioButton v-model="form.identity" value="學生" />
        <label for="ingredient1" class="ml-2">學生</label>
      </div>
      <div class="flex align-items-center">
        <RadioButton v-model="form.identity" value="教師" />
        <label for="ingredient2" class="ml-2">教師</label>
      </div>
      <div class="flex align-items-center">
        <RadioButton v-model="form.identity" value="職員" />
        <label for="ingredient3" class="ml-2">職員</label>
      </div>
      <div class="flex align-items-center gap-2">
        <RadioButton v-model="form.identity" value="其他" />
        <div>其他</div>
        <InputText v-model="identity" class="p-1" />
      </div>
    </div>
    <hr class="hr" />
    <div class="title">所屬學院(若非學生請填寫服務單位)</div>
    <Dropdown v-model="form.college" :options="collegeList" placeholder="請選擇" class="w-full" />
    <InputText v-show="form.college == '其他'" v-model="college" class="p-1 w-full my-2" placeholder="請輸入其他學院" />
    <hr class="hr" />
    <div class="title">就讀年級</div>
    <div class="flex flex-wrap gap-3 flex-col">
      <div class="flex align-items-center">
        <RadioButton v-model="form.grade" value="大學部" />
        <label for="ingredient1" class="ml-2">大學部</label>
      </div>
      <div class="flex align-items-center">
        <RadioButton v-model="form.grade" value="碩士班" />
        <label for="ingredient2" class="ml-2">碩士班</label>
      </div>
      <div class="flex align-items-center">
        <RadioButton v-model="form.grade" value="博士班" />
        <label for="ingredient3" class="ml-2">博士班</label>
      </div>
      <div class="flex align-items-center">
        <RadioButton v-model="form.grade" value="在職專班" />
        <label for="ingredient3" class="ml-2">在職專班</label>
      </div>
      <div class="flex align-items-center gap-2">
        <RadioButton v-model="form.grade" value="其他" />
        <div>其他</div>
        <InputText v-model="grade" class="p-1" />
      </div>
    </div>
    <hr class="hr" />
    <div class="title">針對此次校方有約系列活動滿意度為何？</div>
    <Rating v-model="form.q1_score" :cancel="false" class="w-full" />
    <hr class="hr" />
    <div class="title">為何給這個分數？</div>
    <Textarea v-model="form.q1_comment" class="p-1 w-full" />
    <hr class="hr" />
    <div class="title">各單位對於學生反應事項之回答滿意度</div>
    <Rating v-model="form.q2_score" :cancel="false" class="w-full" />
    <hr class="hr" />
    <div class="title">為何給這個分數？</div>
    <Textarea v-model="form.q2_comment" class="p-1 w-full" />
    <hr class="hr" />
    <div class="title">有對哪一個單位的回答特別印象深刻嗎？為何？</div>
    <Textarea v-model="form.q3_comment" class="p-1 w-full" />
    <hr class="hr" />
    <div class="title">針對校長候選人政見說明環節之滿意度？</div>
    <Rating v-model="form.q4_score" :cancel="false" class="w-full" />
    <hr class="hr" />
    <div class="title">為何給這個分數？</div>
    <Textarea v-model="form.q4_comment" class="p-1 w-full" />
    <hr class="hr" />
    <div class="title">對學生會舉辦此次與校方有約系列活動有任何建議嗎？(包括意見搜集階段、前導活動、與校方有約座談會)</div>
    <Textarea v-model="form.q5_comment" class="p-1 w-full" />
    <hr class="hr" />
    <div class="title">與校方有約結束了，但學生會對於學生意見的傳達、反應會一直持續下去，目前，你還有任何想要反應之事項可以提供給學生會知道嗎？</div>
    <Textarea v-model="form.q6_comment" class="p-1 w-full" />
    <hr class="hr" />
    <Button class="block button" @click="submit" label="送出與簽退" />
  </div>
</template>

<style scoped lang="scss">
  .title {
    @apply text-lg font-medium mb-2;
  }
  .hr {
    @apply my-3;
  }
</style>
