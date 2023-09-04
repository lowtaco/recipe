<template>
  <div class="story">
    <touch-zones @back="$emit('back')" @next="$emit('next')"/>
    <img :src="url">
  </div>
</template>
<script>
import storyTouchZones from './story_touch_zones'
export default {
  props: ['url'],
  components: {
    'touch-zones': storyTouchZones
   },
  data() {
    return {
      sel: 1
    }
  }
};
</script>
<style>

.story {
  position: relative;
  display: flex;
  justify-content: center;
  width: 100%;
  height: 100%;
  border-radius: 20px;
  overflow: hidden;
  background-color: black;
}

img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

</style>