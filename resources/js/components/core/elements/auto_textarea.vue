<template>
  <textarea v-model="text" :placeholder="placeholder"></textarea>
</template>
<script>

export default {
  props: ['placeholder'],
  data() {
    return {
      text: null
    }
  },
  watch: {
    text() {
      if(this.text) {
        this.$emit('update:modelValue', this.text)
      }
    }
  },
  mounted() {
    const tx = document.getElementsByTagName("textarea");
    for (let i = 0; i < tx.length; i++) {
      tx[i].setAttribute("style", "height:" + 68 + "px;overflow-y:hidden;");
      tx[i].addEventListener("input", OnInput, false);
    }

    function OnInput() {
      this.style.height = 68;
      this.style.height = (this.scrollHeight) + "px";
    }
  },
};
</script>