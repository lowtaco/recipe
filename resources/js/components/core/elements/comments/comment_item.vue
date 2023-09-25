<template>
  <div class="comments-viewer">


    <h4>{{ comment.author }}</h4>
    <p>{{ comment.content }}</p>
    <a>{{ comment.likes }}</a>

    <comments-viewer :comments="comment.replies"/>
  </div>
</template>
<script>


export default {
  props: ['user', 'comment'],
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