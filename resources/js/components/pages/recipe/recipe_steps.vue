<template>
  <div class="recipe-steps">
    <h4>Пошаговый рецепт</h4>
    <div class="recipe-step" v-for="(step, index) in steps">
      <div class="picture">
        <span>Шаг {{ index + 1 }}</span>
        <img :src="step.photo">
      </div>
      <p>{{ step.desc }}</p>
    </div>

    <div class="recipe-step" v-if="serving">
      <div class="picture">
        <span>Подача</span>
        <img :src="serving.photo">
      </div>
      <p>{{ serving.desc }}</p>
    </div>
  </div>
</template>
<script>

export default {
  props: ['steps', 'serving'],
};
</script>