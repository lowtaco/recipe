<template>
  <div class="page shopping-lists no-padding" v-if="!addListMode && !listViewerMode && !editListMode">
    
    <div class="page-content">
      <loader v-if="loading"/>
      <div class="shopping-lists">
        <div class="swipe-tabs">
          <div class="swipe-tabs-header">
            <div class="swipe-tab" :class="{selected: selectedTab == index}" v-for="(tab, index) in tabs" @click="selectedTab = index">
              <span>{{ tab }}</span>
            </div>
          </div>
          
          <div class="swipe-tabs-content" v-touch:swipe.left="swipeLeft" v-touch:swipe.right="swipeRight">
            <div class="swipe-tab-content">
              <Transition name="slide">
                <component is="RecipeLists" :lists="listsRecipe" v-if="selectedTab == 0" ></component>
              </Transition>
              <Transition name="slide-reverse">
                <component is="PersonalLists" :lists="listsPersonal" v-if="selectedTab == 1"></component>
              </Transition>
            </div>
          </div>
        </div>
      </div>

      <div class="page-empty" v-if="isListEpmty">
        <div class="pe-wrapper">
          <span>{{ $strings.pages.shopping_lists.empty.title }}</span>
          <img>
          <p>{{ $strings.pages.shopping_lists.empty.msg }}</p>
        </div>
      </div>
    </div>

  </div>
</template>
<script>
import PersonalLists from "./shopping_list/PersonalLists";
import RecipeLists from "./shopping_list/RecipeLists";

export default {
  props: ['logged', 'user'],
  components: {
    PersonalLists,
    RecipeLists
  },
  data() {
    return {
      selectedTab: 0,
      tabs: [
        "Рецепты",
        "Мои списки"
      ],
      listsRecipe: null,
      listsPersonal: null,
      loading: true
    }
  },
  watch: {
    selectedTab() {
      localStorage.setItem('shoppingListTab', this.selectedTab);
    }
  },
  mounted() {
    this.$emit("hideMenu", false);
    this.getLists();
    if(localStorage.getItem('shoppingListTab')) {
      this.selectedTab = localStorage.getItem('shoppingListTab');
    };
  },
  methods: {
    getLists() {
      this.loading = true;
      axios.post('/get-user-shopping-lists', {user: this.user.email}).then((response) => {
        // Фильтруем списки на личные и сохраненные
        let personal = _.filter(response.data, (l) => {
          return l.personal == 1;
        })
        let recipe = _.filter(response.data, (l) => {
          return l.personal == 0;
        })

        this.listsPersonal = personal;
        this.listsRecipe = recipe;
        this.loading = false;
      })
    },
    swipeLeft() {
      if(this.selectedTab != 1) {
        this.selectedTab = 1;
      }
    },
    swipeRight() {
      if(this.selectedTab != 0) {
        this.selectedTab = 0;
      }
    }
  },
};
</script>