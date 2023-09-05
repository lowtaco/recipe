<template>
  <div class="highlights-slider">
    <div class="item" v-for="item in items" :class="{selected: item.checked}">
      <span>{{ item.name }}</span>
      <div class="indicator"></div>
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
        name: "Все рецепты",
        checked: true,
        link: '#'
      },
      {
        name: "Какая-то папка",
        checked: false,
        link: '#'
      },
      {
        name: "Какая-то папка",
        checked: false,
        link: '#'
      },
      {
        name: "Какая-то папка",
        checked: false,
        link: '#'
      }
     ]
    }
  },
  mounted() {
   
  }
};
</script>