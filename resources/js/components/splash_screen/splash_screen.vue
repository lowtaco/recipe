<template>
  <div class="splash-screen">

    <div class="screens">
      <div class="screen">

      </div>
    </div>

  </div>

  
</template>
<script>

export default {
  components: {
  },
  data() {
    return {
    }
  },
  mounted() {
    this.$emit("hideMenu", true);
  },
  unmounted() {
    this.$emit("hideMenu", false);
  },
  methods: {
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