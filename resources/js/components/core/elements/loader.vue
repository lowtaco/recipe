<template>
  <div class="loader">
    <svg
      class="ring"
      viewBox="25 25 50 50"
      stroke-width="5"
    >
      <circle cx="50" cy="50" r="20" />
    </svg>

    <span v-if="status">{{ status }}</span>
  </div>
</template>
<script>

export default {
  props: ['checked', 'status'],
};
</script>
<style>


</style>