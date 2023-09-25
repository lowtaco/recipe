<template>
  <div class="comment">
    <div class="comment-content">
      <div class="author-avatar">
        <img :src="author.picture">
      </div>

      <div class="box">
        <div class="author-name">
          <span>@{{ author.nickname }}</span>
        </div>
        <div class="comment-body">
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Delectus illum ab, non ullam dicta autem. Molestias ad eum, iure aperiam quaerat incidunt, libero optio inventore odio illo assumenda, rerum impedit?</p>
        </div>

        <div class="statistics">
          <div class="replies-menu">
            <div class="user-replies" @click="repliesViewingMode = !repliesViewingMode" v-if="comment.replies_amount">
              <span>{{ comment.replies_amount }}</span>
              <span>Ответов</span>
            </div>
            <div class="add-reply-btn" @click="addReplyMode = !addReplyMode"><span>Ответить</span></div>
          </div>

          <div class="likes">
            <span v-if="comment.likes_amount">{{ comment.likes_amount }}</span>
            <icon icon="like" size="tiny"/>
          </div>
        </div>

        <div class="add-reply" v-if="addReplyMode">
          <comment-add />
        </div>
      </div>
    </div>
    
    <div class="replies" v-if="repliesViewingMode">
      <div class="reply-divider"></div>
      <comments-viewer :comments="comment.replies"/>
    </div>
    
  </div>

</template>
<script>


export default {
  props: ['user', 'comment'],
  components: {

  },
  data() {
    return {
      author: {},
      addReplyMode: false,
      repliesViewingMode: false,
    }
  },
  watch: {
   
  },
  async mounted() {
    await this.getAuthorInfo();
  },
  methods: {
    async getAuthorInfo() {
      try {
        const response = await axios.post('/get-user-info', {id: this.comment.author_id});
        this.author = response.data[0];
        console.log(this.author);
      } catch (e) {
        console.log(e);
      }
    },
  }
};
</script>

<style scoped>
.comment {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.comment-content {
  display: inline-flex;
  gap: 8px;
}

.author-avatar {
  display: block;
  width: 48px;
  height: 48px;
  background-color: gray;
  border-radius: 50%;
  overflow: hidden;
  flex-shrink: 0;
}

.author-avatar img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}


.box {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.author-name {
  font-weight: 600;
  font-size: 14px;
}

.comment-body {
  display: block;
}

.comment-body p {
  margin: 0;
}


.statistics {
  display: inline-flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  font-size: 14px;
}

.replies-menu {
  display: inline-flex;
  align-items: center;
  gap: 8px;
}

.user-replies {
  display: inline-flex;
  gap: 4px;
}

.add-reply-btn {
  display: block;
}

.likes {
  display: inline-flex;
  align-items: center;
  gap: 8px;
}


.replies {
  display: inline-flex;
  gap: 8px;
}

.reply-divider {
  display: block;
  width: 2px;
  border-radius: 5px;
  height: auto;
  background-color: grey;
  flex-shrink: 0;
}


</style>