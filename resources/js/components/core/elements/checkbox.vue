<template>
  <div class="checkbox-no-text" v-if="!isText">
    <div class="checkbox" v-if="!checked">
    </div>
    <div class="checkbox checked" v-if="checked">
      <icon icon="checkbox" size="tiny"/>
      <span v-if="isText">{{ text }}</span>
    </div>
  </div>
  
  <div class="checkbox-texted" v-if="isText">
    <div class="checkbox" v-if="!checked">
    </div>
    <div class="checkbox checked" v-if="checked">
      <icon icon="checkbox" size="tiny"/>
    </div>
    <span v-if="isText">{{ text }}</span>
  </div>
</template>
<script>

export default {
  props: ['checked', 'isText', 'text']
};
</script>