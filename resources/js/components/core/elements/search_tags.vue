<template>
  <div class="search_tags">
    <div class="item" v-for="tag in items">
      <span>{{ tag.name }}</span>
      <icon icon="close" size="tiny"/>
    </div>
  </div>
</template>
<script>

export default {
  props: ['tags'],
  data() {
    return {
     items: [
      {
        name: "Чеснок",
        link: "chesnok"
      },
      {
        name: "Картофель",
        link: "chesnok"
      },
      {
        name: "Салат айсберг",
        link: "chesnok"
      },
      {
        name: "Филе куриное",
        link: "chesnok"
      },
      {
        name: "Помидор",
        link: "chesnok"
      }
     ]
    }
  },
  mounted() {
   
  }
};
</script>