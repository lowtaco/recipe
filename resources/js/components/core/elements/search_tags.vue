<template>
  <div class="search_tags">
    <div class="item" v-for="tag in tags">
      <span>{{ tag.name }}</span>
      <div class="delete" @click="$emit('delete', tag.id)">
        <icon icon="close" size="tiny"/>
      </div>
    </div>
  </div>
</template>
<script>

export default {
  props: ['tags'],
  data() {
    return {
    }
  },
  mounted() {
   
  }
};
</script>