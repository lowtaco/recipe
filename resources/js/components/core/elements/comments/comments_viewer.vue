<template>
  <div class="comments-viewer">
    <comment-item :user="user" :comment="comment" v-for="comment in comments"/>
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

<style scoped>
.comments-viewer {
  display: flex;
  flex-direction: column;
  gap: 16px;
  width: 100%;
}

</style>