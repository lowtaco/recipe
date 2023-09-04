<template>
  <div class="r-select">
    <div class="input-field" @click="fullscreen = true">
      <input type="text" v-model="input" :placeholder="placeholder">
      <div class="select-icon">
        <icon icon="down"/>
      </div>
    </div>
  </div>

  <Transition name="fade">
    <select-fullscreen :title="title" :request="request" @goBack="fullscreen = false" @selectOption="selectOption" v-if="fullscreen"/>
  </Transition>
    
</template>
<script>

import select_fullscreen from './select_fullscreen.vue';

export default {
  props: ['placeholder', 'title', 'request'],
  components: {
    'select-fullscreen': select_fullscreen
  },
  data() {
    return {
      fullscreen: false,
      input: null,
    }
  },
  methods: {
    selectOption(option) {
      this.input = option.name;
      this.$emit('update:modelValue', option)
    }
  }
};
</script>