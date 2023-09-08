<template>
  <div class="num-editor" @click="getNum">
    <div class="edit less" @click="less">
      <icon icon="minus" size="tiny"/>
    </div>
    <span>{{ modelValue }}</span>
    <div class="edit big" @click="big">
      <icon icon="plus" size="tiny"/>
    </div>
  </div>
</template>
<script>

export default {
  props: ['modelValue'],
  methods: {
    less() {
      if(this.modelValue > 1) {
        let num = this.modelValue;
        num--;
        this.$emit('update:modelValue', num);
        this.$emit('changed');
      }
    },
    big() {
      let num = this.modelValue;
      num++;
      this.$emit('update:modelValue', num);
      this.$emit('changed');
    }
  }
};
</script>