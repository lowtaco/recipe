<template>
  <div class="difficulty-spiciness-viewer">
    <div class="card">
      <div class="icon-row spiciness">
        <div class="item" :class="{checked: item <= spiciness}" v-for="item in total">
          <icon icon="spiciness" size="small"/>
        </div>
      </div>
      <span>Острота</span>
    </div>
    <div class="card">
      <div class="icon-row difficulty">
        <div class="item" :class="{checked: item <= difficulty}" v-for="item in total">
          <icon icon="difficulty" size="small"/>
        </div>
      </div>
      <span>Сложность</span>
    </div>
  </div>
</template>
<script>

export default {
  props: ['difficulty', 'spiciness', 'total'],
};
</script>