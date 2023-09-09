<template>
  <div class="difficulty-spiciness">
    <div class="card">
      <div class="icon-row">
        <span>🌶️</span>
        <span>🌶️</span>
        <span>🌶️</span>
        <span>🌶️</span>
        <span>🌶️</span>
      </div>
      <span>Острота</span>
    </div>
    <div class="card">
      <div class="icon-row">
        <span>👨🏻‍🍳</span>
        <span>👨🏻‍🍳</span>
        <span>👨🏻‍🍳</span>
        <span>👨🏻‍🍳</span>
        <span>👨🏻‍🍳</span>
      </div>
      <span>Сложность</span>
    </div>
  </div>
</template>
<script>

export default {
  props: ['picture', 'nickname', 'first_name', 'last_name'],
};
</script>