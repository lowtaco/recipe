<template>
  <div class="popup-menu-wrapper">
    <div class="popup-menu" v-if="type == 'center'">
      <div class="popup-menu-item" :class="item.type" v-for="item in items" @click="$emit('callback', item.link)">
        <span>{{ item.name }}</span>
      </div>
    </div>
    <div class="popup-menu element" :style="{'top': i_top, 'right': i_right}" v-if="type == 'element'">
      <div class="popup-menu-item" :class="item.type" v-for="item in items" @click="$emit('callback', item.link)">
        <span>{{ item.name }}</span>
      </div>
    </div>
    <div class="popup-menu-fake-bg" @click="$emit('goBack')"></div>
  </div>
</template>
<script>

export default {
  props: ['items', 'type', 'elId', 'parentId'],
  data() {
    return {
      i_top: null,
      i_right: null
    }
  },
  mounted() {
    if(this.type == 'element') {
      let x = document.getElementById(this.elId)
      let rect = x.getBoundingClientRect()
      let parent = document.getElementById(this.parentId)
      let parentRect = parent.getBoundingClientRect()
      this.i_right =  parentRect.width - rect.right + 'px';
      this.i_top = rect.top + 'px';
    }
  }
};
</script>