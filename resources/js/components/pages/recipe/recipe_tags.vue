<template>
  <div class="recipe_tags">
    <div class="tag">
      <span>ЗОЖ</span>
    </div>
    <div class="tag">
      <span>Походная еда</span>
    </div>
    <div class="tag">
      <span>Вторые блюда из каракатицы</span>
    </div>
  </div>
</template>
<script>

export default {
  props: [],
};
</script>

<style scoped>
.recipe_tags {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  -ms-overflow-style: none;
  overflow-y: auto;
  box-sizing: border-box;
  margin: 0 -20px;
  padding: 0 20px;
}

.recipe_tags::-webkit-scrollbar { height: 0; }

.tag {
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 20px;
  height: 30px;
  padding: 0 12px;
  width: fit-content;
  background-color: #eaeaea;
  font-size: 14px;
  flex-shrink: 0;
}

</style>