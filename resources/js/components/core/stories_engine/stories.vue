<template>
  <div class="stories">
    

    <storie />


  </div>
</template>
<script>
import storie from "./storie"

export default {
  props: ['lists', 'user'],
  components: {
    storie
  },
  data() {
    return {
      storiesData: {
        
      }
    }
  },
  mounted() {
    this.$emit('hideMenu', true)
  },
  methods: {
    
  },
};
</script>