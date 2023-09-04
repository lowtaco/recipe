<template>
  <div class="mobile-menu-wrap">
    <div class="mobile-menu-item" :class="{selected: current == item.link}" v-for="item in $mobile_menu" @click="pageSelect(item.link)">
      <div class="mmi_icon">
        <icon :icon="item.icon"/>
      </div>
      <div class="mmi_label" v-if="settings.labels">
        <span>{{ item.label }}</span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    settings: {
      type: Object,
      default: {
        labels: false
      }
    },
    current: {
      type: String,
      default: "Home"
    }
  },
  methods: {
    pageSelect(link) {
      this.$emit('handler', link);
    }
  }
};
</script>