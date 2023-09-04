<template>
  <div class="page add-shopping-list no-padding">
    
    <div class="page-header no-border absolute" style="background-color: transparent;" id="slv-parent">
      <div class="header-w-button between">
        <div class="goBackButton" @click="$emit('goBack')"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M9.578 17.137a.625.625 0 0 1-.882-.058l-5.833-6.667a.625.625 0 0 1 0-.823l5.833-6.667a.625.625 0 1 1 .94.823l-4.925 5.63h11.956a.625.625 0 0 1 0 1.25H4.711l4.926 5.63a.625.625 0 0 1-.058.882Z" fill="#030D45"/></svg></div>
        <div class="list-viewer-shared"></div>
        <div class="popup-menu-button" @click="additionalPopupActive = true" id="slv-popup-btn">•••</div>
      </div>
    </div>

    
    <div class="page-content" id="scroll-box">

      <div class="recipe" >
        <div class="banner">
          <img src="https://w.forfun.com/fetch/00/00c3d0bc0617f22de4af13e6322b6e58.jpeg" id="scalable">
        </div>

        <div class="content" id="ref-box">
          <div class="swipe-trigger"></div>

          <div class="recipe-info">
            <div class="info-header">
              <div class="title">
                <h1>Сочная курица с мясом</h1>
                <span>Русская кухня</span>
              </div>
              <div class="like-buttons">
                <div class="item">
                  <icon icon="like"/>
                </div>
                <div class="item">
                  <icon icon="favorite"/>
                </div>
              </div>
            </div>

          </div>

        </div>

      </div>
    
    </div>


  </div>
</template>
<script>
import axios from 'axios';


export default {
  props: ['checked', 'isText', 'text'],
  data() {
    return {
      recipes: null,
      scrollBox: null,
      recipe_id: 44
    }
  },
  mounted() {
    this.scrollBox = document.getElementById('scroll-box')
    this.scrollBox.addEventListener('scroll', this.handleScroll);
    this.getRecipe();
  },
  unmounted() {
    this.scrollBox.removeEventListener("scroll", this.handleScroll);
  },
  methods: {
    getRecipe() {
      axios.post('/get-recipe', {
        id: this.recipe_id
      }).then((response) => {
        console.log(response.data[0])
      })
    },
    handleScroll () {
      let reference = document.getElementById('ref-box')
      let rect = reference.getBoundingClientRect()
      let y = rect.y
      let scalable = document.getElementById('scalable')

      if (y < 200) {
        scalable.style.transform = `scale(${1.5})`;
        scalable.style.opacity = 0.5;
        reference.style.borderRadius = '0 0 0 0'
      } else {
        scalable.style.transform = `scale(${1})`;
        scalable.style.opacity = 1;
        reference.style.borderRadius = '30px 30px 0 0'
      }
    }
  }


};
</script>

<style>

</style>