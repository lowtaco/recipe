<template>
  <div class="mp-slider">
    <div class="item" v-for="item in items" @click="selectCategory(item.id)">
      <div class="icon">
        <span>{{ item.icon }}</span>
      </div>
      <span :class="{checked: current == item.id}">{{ item.short_name }}</span>
    </div>
  </div>
  
</template>
<script>
import axios from 'axios';

export default {
  props: ['modelValue'],
  data() {
    return {
      current: this.modelValue,
      items: [
        {
          id: 0,
          short_name: "Лента",
          checked: true,
          icon: "🧡",
          link: "all"
        }
      ]
    }
  },
  mounted() {
    this.getCategories();
  },
  methods: {
    getCategories() {
      axios.get('/get-recipes-categories').then((response) => {
        this.items = this.items.concat(response.data);
      });
    },
    selectCategory(id) {
      this.current = id;
      this.$emit('update:modelValue', this.current);
    }
  }
};
</script>