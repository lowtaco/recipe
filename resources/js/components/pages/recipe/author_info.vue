<template>
  <div class="author">
    <div class="picture">
      <img :src="picture" >
    </div>
    <div class="name">
      <h4>{{ first_name }} {{ last_name }}</h4>
      <span>@{{ nickname }}</span>
    </div>
  </div>
</template>
<script>

export default {
  props: ['picture', 'nickname', 'first_name', 'last_name'],
};
</script>