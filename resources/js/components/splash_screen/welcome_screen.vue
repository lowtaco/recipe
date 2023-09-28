<template>
  <div class="page">
    <welcome_screen_fake_bg @animateEnd="startAnimate"/>
    <div class="text-box">
      <div class="header">
        <h1>recipe</h1>
        <div class="header-quote">
          <h4>Вдохновение в каждом блюде!</h4>
        </div>
      </div>

      <div class="body animated" ref="auth_welcome_body">
        <authorization @authorized="$emit('authorized')"/>
      </div>
    </div>

  </div>
</template>
<script>

import welcome_screen_fake_bg from './welcome_screen_fake_bg';
import authorization from './authorization';

export default {
  components: {
    welcome_screen_fake_bg,
    authorization
  },
  data() {
    return {
      AuthShow: false
    }
  },
  mounted() {
    this.$emit("hideMenu", true);
  },
  unmounted() {
    this.$emit("hideMenu", false);
  },
  methods: {
    startAnimate() {
      this.AuthShow = true
      const body = this.$refs.auth_welcome_body;
      setTimeout(() => {
        body.classList.remove('animated')
      }, 400)
    }
  },
};
</script>
<style scoped>

.text-box {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  position: absolute;
  width: 100%;
  height: 100%;
  box-sizing: border-box;
}

.header {
  display: flex;
  flex-direction: column;
  gap: 48px;
  padding: 24px;
  height: 30%;
  box-sizing: border-box;
}

.header h1 {
  color: white;
  font-size: 42px;
  font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
}

.header-quote {
  display: inline-flex;
  align-items: center;
  gap: 8px;
}

.header-quote h4 {
  font-size: 26px;
  color: white;
}

.body {
  display: flex;
  padding: 24px;
  height: 40%;
  box-sizing: border-box;
  transition: .8s all ease;
}

.body.animated {
  opacity: 0;
}

</style>