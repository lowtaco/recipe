<template>
  <div class="page">
    <welcome_screen_fake_bg />
    <div class="text-box">
      <div class="header">
        <h1>recipe</h1>
        <div class="header-quote">
          <h4>Вдохновение в каждом блюде!</h4>
        </div>
      </div>

      <div class="body">
        <div class="quotes">
          <div class="quote">
            <span><b>Создавайте</b> и сохраняйте собственные рецепты</span>
          </div>
          <div class="quote">
            <span><b>Ищите</b> рецепты по названию, ингредиентам или типу блюда</span>
          </div>
          <div class="quote">
            <span><b>Получайте</b> рекомендации рецептов и статей</span>
          </div>
        </div>
        <div class="next-btn">
          <button class="square big">
            <icon icon="next"/>
          </button>
        </div>
      </div>
    </div>

  </div>
</template>
<script>

import welcome_screen_fake_bg from './welcome_screen_fake_bg';

export default {
  components: {
    welcome_screen_fake_bg
  },
  data() {
    return {

    }
  },
  methods: {
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
  display: flex;
}

.header-quote h4 {
  font-size: 26px;
  color: white;
}

.body {
  padding: 24px;
  height: 40%;
  box-sizing: border-box;
}

.quotes {
display: flex;
flex-direction: column;
gap: 20px;
}

.quote {
  font-size: 20px;
}

.quote b {
  color: #ffa62b;
}

.next-btn {
  margin-top: 20px;
  display: flex;
  justify-content: flex-end;
}

</style>