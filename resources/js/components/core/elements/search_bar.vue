<template>
  <div class="search-bar">
    <div class="search-icon">
      <icon icon="search"/>
    </div>
    <div class="filters-icon" v-if="filters">
      <icon icon="filters"/>
    </div>
    <input type="text" :class="{noFilters: !filters}" placeholder="Поиск">
  </div>
</template>
<script>

export default {
  props: ['filters']
};
</script>