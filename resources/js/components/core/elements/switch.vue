<template>
  <div class="switchbox" @click="checked = !checked">
    <span>{{ placeholder }}</span>
    <input id="switchcheckbox" type="checkbox" :checked="checked"/><label for="switchcheckbox" id="switch"></label>
  </div>
</template>
<script>

export default {
  props: ['checked', 'placeholder']
};
</script>