<template>
  <div class="info-header">
    <div class="title">
      <h1>{{ name }}</h1>
      <span>{{ kitchen }}</span>
    </div>
    <div class="like-buttons">
      <div class="item" @click="$emit('like')">
        <icon icon="like"/>
      </div>
      <div class="item" @click="$emit('save')">
        <icon icon="favorite"/>
      </div>
    </div>
  </div>
</template>
<script>

export default {
  props: ['name', 'kitchen'],
};
</script>