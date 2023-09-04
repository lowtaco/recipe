<template>
  <div class="switchbox" @click="checked = !checked">
    <span>Switch</span>
    <input id="switchcheckbox" type="checkbox" :checked="checked"/><label for="switchcheckbox" id="switch"></label>
  </div>
</template>
<script>

export default {
  props: ['checked']
};
</script>