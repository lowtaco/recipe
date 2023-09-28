<template>
  <div class="splash-screen">

    <div class="screens" v-touch:swipe.left="swipeLeft" v-touch:swipe.right="swipeRight">
      <div class="screen" v-if="screenId == 0">
        <welcome_screen />
      </div>
      <div class="screen" v-if="screenId == 1">
        <h1>2</h1>
      </div>
      <div class="screen" v-if="screenId == 2">
        <authorization />
      </div>

    </div>
    <div class="paginate">
      <div :class="{active: screenId == index}" class="paginate-item" v-for="(pag, index) in total" @click="screenId = index"></div>
    </div>

  </div>

  
</template>
<script>
import welcome_screen from './welcome_screen';
import authorization from './authorization';

export default {
  components: {
    welcome_screen,
    authorization
  },
  data() {
    return {
      screenId: 2,
      total: 3
    }
  },
  mounted() {
    this.$emit("hideMenu", true);
  },
  unmounted() {
    this.$emit("hideMenu", false);
  },
  methods: {
    swipeLeft() {
      if(this.screenId < this.total - 1) {
        this.screenId += 1;
      }
    },
    swipeRight() {
      if(this.screenId > 0) {
        this.screenId -= 1;
      }
    }
  },
};
</script>
<style scoped>
.splash-screen {
  position: relative;
  display: flex;
  flex-direction: column;
  width: 100%;
  height: 100%;
  box-sizing: border-box;
}

.screens {
  display: block;
  width: 100%;
  height: -webkit-fill-available;
}

.screen {
  position: relative;
  display: flex;
  width: 100%;
  height: 100%;
}

.paginate {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 16px;
  height: 56px;
  flex-shrink: 0;
}

.paginate-item {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  box-sizing: border-box;
  border: 1px solid #eaeaea;
  transition: .3s all ease;
}

.paginate-item.active {
  border-color: #ffa62b;
  background-color: #ffa62b;
}

</style>