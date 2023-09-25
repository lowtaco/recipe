<template>
  <div class="comments-viewer">
    <comment-item :comment="comment" v-for="comment in comments"/>
  </div>
</template>
<script>

export default {
  props: ['user', 'comments'],
  components: {
  },
  data() {
    return {
    }
  },
  watch: {
   
  },
  mounted() {

  },
};
</script>