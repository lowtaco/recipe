<template>
  <div class="highlights-slider">
    <div class="item" v-for="(item, index) in items" :class="{selected: selectedTab == index}" @click="checkTab(index)">
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
      selectedTab: 0,
     items: [
      {
        name: "Рецепты",
        link: '#'
      },
      {
        name: "Записи",
        link: '#'
      },
     ]
    }
  },
  mounted() {
   
  },
  methods: {
    checkTab(index) {
      this.selectedTab = index;
      this.$emit('update:modelValue', index)
    }
  }
};
</script>