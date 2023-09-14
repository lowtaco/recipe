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
        name: "Рецепты",
        checked: true,
        link: '#'
      },
      {
        name: "Статьи",
        checked: false,
        link: '#'
      },
     ]
    }
  },
  mounted() {
   
  }
};
</script>