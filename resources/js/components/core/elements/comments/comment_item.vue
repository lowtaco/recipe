<template>
  <div class="comment">
    <div class="comment-content">
      <div class="author-avatar">
        <img :src="author.picture" v-if="author.picture">
      </div>

      <div class="box">
        <div class="author-name" v-if="author.first_name && author.last_name">
          <span>{{ author.first_name + ' ' + author.last_name }}</span>
        </div>
        <div class="author-name" v-if="!author.first_name && !author.last_name">
          <span>Загрузка...</span>
        </div>
        <div class="comment-body">
          <p>{{ comment.body }}</p>
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
            <div class="like-btn liked" @click="like">
              <icon icon="like" size="tiny" />
            </div>
          </div>
        </div>

        <div class="add-reply" v-if="addReplyMode">
          <comment-add placeholder="Ответить" @addComment="addReply"/>
        </div>
      </div>
    </div>
    
    <div class="replies" v-if="repliesViewingMode">
      <div class="reply-divider"></div>
      <div class="replies-loader-box" v-if="replies_loading">
        <loader />
      </div>
      <comments-viewer :comments="replies" :user="user" v-if="!replies_loading"/>
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
      replies: null,
      replies_loading: false
    }
  },
  watch: {
    repliesViewingMode() {
      if(this.repliesViewingMode) {
        this.addReplyMode = false;
        this.getReplies();
      }
    },
    addReplyMode() {
      if(this.addReplyMode) {
        this.repliesViewingMode = false;
      }
    }
   
  },
  async mounted() {
    await this.getAuthorInfo();
    
  },
  methods: {
    async getAuthorInfo() {
      try {
        const response = await axios.post('/get-user-info', {id: this.comment.author_id});
        this.author = response.data[0];
      } catch (e) {
        console.log(e);
      }
    },
    async getReplies() {
      this.replies_loading = true;
      try {
        const response = await axios.post('/get-comments', {
          post_id: this.comment.id
        })
        this.replies = response.data;

      } catch (e) {
        console.log(e)
      } finally {
        this.replies_loading = false;
      }
    },
    async addReply(body) {
      try {
        await axios.post('/add-reply', {
          is_reply: 1,
          post_id: this.comment.id,
          author_id: this.user.id,
          body: body,
        })
        this.comment.replies_amount += 1;
        this.addReplyMode = false;
        this.getReplies();
        this.repliesViewingMode = true;
      } catch(e) {
        console.log(e)
      }
    },
    like() {
      console.log('test')
    }
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
  width: 100%;
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

.replies-loader-box {
  position: relative;
  display: block;
  width: 100%;
  height: 56px;
}

.reply-divider {
  display: block;
  width: 2px;
  border-radius: 5px;
  height: auto;
  background-color: grey;
  flex-shrink: 0;
}

.liked .icon svg path {
  fill: pink
}


</style>