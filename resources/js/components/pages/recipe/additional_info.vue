<template>
  <div class="additional-info">
    
    <div class="card">
      <h4>Описание</h4>
      
      <div class="description"><p>{{ description }}</p></div>
      
      <div class="timings">
        <div class="item">
          <span>{{ cooking_time }}</span>
          <p>Время приготовления</p>
        </div>
        <div class="item">
          <span>{{ kitchen_time }}</span>
          <p>Время на кухне</p>
        </div>
      </div>

      <div class="list">
        <div class="item">
          <div class="indicator"></div>
          <div class="item-content">
            <span>🌅 Подойдет на:</span>
            <p>{{ meal.charAt(0).toUpperCase() + meal.substring(0, meal.length - 2).slice(1) }}</p>
          </div>
        </div>

        <div class="item">
          <div class="indicator"></div>
          <div class="item-content">
            <span>🍳 Способы приготовления:</span>
            <p>{{ cooking_methods.charAt(0).toUpperCase() + cooking_methods.substring(0, cooking_methods.length - 2).slice(1) }}</p>
          </div>
        </div>

        <div class="item">
          <div class="indicator"></div>
          <div class="item-content">
            <span>🍴 Посуда:</span>
            <p>{{ dishes.charAt(0).toUpperCase() + dishes.substring(0, dishes.length - 2).slice(1) }}</p>
          </div>
        </div>
      </div>
      
    </div>
  </div>
</template>
<script>

export default {
  props: ['description', 'cooking_time', 'kitchen_time', 'meal', 'cooking_methods', 'dishes'],
  data() {
    return {
    }
  },
};
</script>