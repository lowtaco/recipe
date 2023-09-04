<template>
 <div class="touch-zones">
  <div class="touch-zone" @click="$emit('back')"></div>
  <div class="touch-zone" @click="$emit('next')"></div>
 </div>
</template>
<script>

export default {
};
</script>
<style>

.touch-zones {
  position: absolute;
  display: inline-flex;
  bottom: 0;
  width: 100%;
  height: 90%;
  z-index: 3;
}

.touch-zone {
  border: 1px solid gray;
  width: -webkit-fill-available;
  box-sizing: border-box;
}

</style>