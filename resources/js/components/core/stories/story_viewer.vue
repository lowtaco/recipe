<template>
  <div class="story_viewer">

    <div class="header">
      <story-pagination :count="getStoriesAmount()" :story="view"/>
      <div class="info">
        <div class="author">
          <div class="circle">
          </div>
          <span>paintedfriend</span>
        </div>
        <icon icon="close"/>
      </div>
    </div>

    <div class="stories">
      <story 
        :url="stories[view].url" 
        @back="previusStory" 
        @next="nextStory"
      />
    </div>

  </div>

  
</template>
<script>
import story from './story'
import storyPagination from './story_pagination'

export default {
  components: {
    'story': story,
    'story-pagination': storyPagination,
   },
   data() {
    return {
      view: 0,
      stories: [
        {
          author: 'paintedfriend',
          url: 'https://upload.wikimedia.org/wikipedia/commons/e/e0/Peizazh_natyror.jpg'
        },
        {
          author: 'paintedfriend',
          url: 'https://upload.wikimedia.org/wikipedia/commons/4/48/Peizazh.jpg'
        }
        ,
        {
          author: 'paintedfriend',
          url: 'https://i.pinimg.com/736x/d1/30/e7/d130e79dce9062d9db4e33836df2a41a--artificial.jpg'
        }
      ]
    }
   },
   mounted() {
   },
   methods: {
    getStoriesAmount() {
      return this.stories.length;
    },
    previusStory() {
      if(this.view > 0) {
        this.view--
      }
    },
    nextStory() {
      if(this.view < (this.getStoriesAmount() - 1)) {
        this.view++
      }
    }
   }

};
</script>
<style>

.story_viewer {
  position: relative;
  width: 100%;
  height: 100%;
  background-color: black;
  color: white;
}

.story-header {
  position: absolute;
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 8px;
  z-index: 2;
  padding: 12px 16px;
  box-sizing: border-box;
}

.header svg path {
  fill: white;
}

.info {
  display: inline-flex;
  width: 100%;
  justify-content: space-between;
  align-items: center;
}

.author {
  display: inline-flex;
  gap: 16px;
  align-items: center;
}

.circle {
  display: block;
  width: 36px;
  height: 36px;
  background-color: #ccc;
  border-radius: 50%;
}

.stories {
  position: absolute;
  display: block;
  width: 100%;
  height: 100%;
}


</style>