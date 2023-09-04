<template>
  <div class="mp-slider">
    <div class="item" v-for="item in items">
      <div class="icon" v-if="item.type != 'more'">
        <span>{{ item.icon }}</span>
      </div>
      <div class="more" v-if="item.type == 'more'">
        <icon icon="next"/>
      </div>
      <span :class="{checked: item.checked}">{{ item.name }}</span>
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
        name: "Лента",
        type: 'default',
        checked: true,
        icon: "🧡",
        link: "all"
      },
      {
        name: "Салаты",
        type: 'default',
        checked: false,
        icon: "🥗",
        link: "#"
      },
      {
        name: "Гарниры",
        type: 'default',
        checked: false,
        icon: "🍚",
        link: "#"
      },
      {
        name: "Закуски",
        type: 'default',
        checked: false,
        icon: "🫓",
        link: "#"
      },
      {
        name: "Выпечка",
        type: 'default',
        checked: false,
        icon: "🥞",
        link: "#"
      },
      {
        name: "Десерты",
        type: 'default',
        checked: false,
        icon: "🍰",
        link: "#"
      },
      {
        name: "Напитки",
        type: 'default',
        checked: false,
        icon: "🍹",
        link: "#"
      },
      {
        name: "Фастфуд",
        type: 'default',
        checked: false,
        icon: "🍔",
        link: "#"
      },
      {
        name: "ЗОЖ",
        type: 'default',
        checked: false,
        icon: "🥦",
        link: "#"
      },
      {
        name: "Категории",
        type: 'more',
        checked: false,
        icon: ">",
        link: '#'
      }
      
     ]
    }
  },
  mounted() {
   
  }
};
</script>