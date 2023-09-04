<template>
  <div class="story-pagination">

    <div class="thumb" v-for="(index) in count">
      <div class="progress" :class="{activeSP: index == (story + 1), finaledSP: index < (story + 1), dafultSP: index > (story + 1)}"></div>
    </div>

  </div>
  
</template>
<script>

export default {
  props: ['count', 'story'],
  watch: {
    story() {
      console.log(this.story);
      
      let i = 0;
      let activeProgress = document.getElementsByClassName('activeSP');
      //console.log(activeProgress[0])
      let progress = setInterval(() => {
        if(i < 10) {
          i++
          console.log(i);
          activeProgress[0].style.width = i + '0%'
        } else {
          clearInterval(progress);
        }
      }, 200)
    }
  },
   mounted() {

   },
   methods: {
    getCount() {
      console.log(this.count)
    }
   }

};
</script>
<style>

.story-pagination {
  position: relative;
  display: flex;
  align-items: center;
  width: 100%;
  gap: 5px;
  box-sizing: border-box;
}

.thumb {
  position: relative;
  display: block;
  width: -webkit-fill-available;
  height: 4px;
  background-color: rgba(255, 255, 255, 0.5);
  border-radius: 50px;
  overflow: hidden;
}

.progress {
  display: block;
  width: 0%;
  height: 4px;
  background-color: rgb(255, 255, 255);
  border-radius: 50px;
  transition: .3s all ease;
}

.progress.finaledSP {
  width: 100%;
}

.progress.dafultSP {
  width: 0%;
}

</style>