<template>
  <div class="ingredient-list-add-recipe">

    <draggable 
      v-model="list" 
      class="list"
      @start="drag=true" 
      @end="drag=false" 
      item-key="name">
      <template #item="{element}">
        <div class="item">
          <div class="item-icon">
            <icon icon="draggable" size="small"/>
          </div>
          <div class="element">
            <span>{{element.name}}</span>
            <span v-if="element.unit">{{ element.amount }} {{ element.unit.name }}</span>
          </div>
          <div class="item-icon" @click="deleteElement(element)">
            <icon icon="trash" size="small"/>
          </div>
        </div>
      </template>
    </draggable>
    
    <div class="add-ingredient">
      <button class="link" @click="fullscreen = true"><icon icon="new" size="tiny"/>{{placeholder}}</button>
    </div>
    
  </div>

  

  <Transition name="fade">
    <add-ingredient-fullscreen :select="select" @goBack="fullscreen = false" @addIngredient="addIngredient" v-if="fullscreen && type == 'ingredient'"/>
  </Transition>

  <Transition name="fade">
    <select-fullscreen :title="title" :request="request" @goBack="fullscreen = false" @selectOption="selectOption" v-if="fullscreen && type == 'list'"/>
  </Transition>
    
</template>
<script>

import add_ingredient_fullscreen from './add_ingredient_fullscreen'
import select_fullscreen from './select_fullscreen';
import draggable from 'vuedraggable'

export default {
  props: ['type', 'placeholder', 'select', 'request', 'title'],
  components: {
    draggable,
    'add-ingredient-fullscreen': add_ingredient_fullscreen,
    'select-fullscreen': select_fullscreen
  },
  data() {
    return {
      fullscreen: false,
      drag: false,
      list: []
    }
  },
  methods: {
    update() {
      this.$emit('update:modelValue', this.list);
    },
    addIngredient(ingredient) {
      this.list.push(ingredient);
      this.update();
    },
    selectOption(option) {
      let newItem = {
        id: option.id,
        name: option.name
      }
      this.list.push(newItem);
      console.log(this.list)
      this.update();
    },
    deleteElement(element) {
      let filteredList = _.filter(this.list, (item) => {
        return item != element;
      })
      this.list = filteredList;
      this.update();
    }
  }
};
</script>