<template>
  <div class="mobile-menu-wrap">
    <div class="mobile-menu-item" :class="{selected: $route.path == item.link}" v-for="item in $mobile_menu" 
    @click="pageSelect(item.link)">
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
  },
  methods: {
    pageSelect(link) {
      this.$router.push(link);
    }
  }
};
</script>