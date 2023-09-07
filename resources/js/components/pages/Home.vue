<template>
  <div class="page">
    <div class="page-content" id="home-scroll-box">
      <div class="home" id="home-reference">
        <div class="home-header">
          <div class="home-title-buttons">
            <h1>recipe</h1>
            <div class="header-buttons">
              <div class="item" @click="$emit('addRecipe')">
                <icon icon="new" />
              </div>
            </div>
          </div>
          <p>Война войной, а обед — по <i>расписанию</i></p>
        </div>

        <div class="home-content">
          <search-bar :filters="true"/>
          <mp-categories />
          <mp-slider v-model="category"/>
          <feed :category="category"/>

        </div>
      </div>
      
    </div>
  </div>
</template>
<script>
import Feed from './recipe_feed/Feed';

export default {
  props: ['logged', 'user'],
  components: {
    'feed': Feed
  },

  data() {
    return {
      category: 0
    }
  },
  mounted() {
    this.$emit("hideMenu", false);
  },
  methods: {

  },
};
</script>