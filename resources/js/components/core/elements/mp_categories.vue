<template>
  <div class="mp-categories">
    <div class="item" v-for="item in items">
      <span>{{ item.name }}</span>
    </div>
  </div>
  
</template>
<script>

export default {
  props: ['items'],
  data() {
    return {
     items: [
      {
        name: "Завтрак",
        link: "#"
      },
      {
        name: "Обед",
        link: "#"
      },
      {
        name: "Ужин",
        link: "#"
      }
     ]
    }
  },
  mounted() {
   
  }
};
</script>