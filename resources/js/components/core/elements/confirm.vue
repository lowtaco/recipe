<template>
  <div class="confirm-wrapper">
    <div class="confirm">
      <span>{{ settings.msg }}</span>
      <div class="confirm-answers-box">
        <div class="cab-button red" @click="$emit('confirm')"><span>{{ settings.yes }}</span></div>
        <div class="cab-button" @click="$emit('goBack')"><span>{{ settings.no }}</span></div>
      </div>
    </div>
  </div>
  <div class="confirm-bg" @click="$emit('goBack')"></div>
</template>
<script>

export default {
  props: ['settings']
};
</script>