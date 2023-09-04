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
                  <component is="RecipeLists" :user="user" :lists="listsRecipe" v-if="selectedTab == 0" @openList="openList"></component>
                  <component is="PersonalLists" :user="user" :lists="listsPersonal" @addList="addListMode = true" @openList="openList" v-if="selectedTab == 1"></component>
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

  <div class="page in-page" v-if="addListMode">
    <add-list :user="user" @goBack="addListMode = false" @openList="openList"/>
  </div>
  <div class="page in-page" v-if="editListMode">
    <edit-list :user="user" :listId="editListId" @goBack="editListMode = false" @openList="openList"/>
  </div>
  <div class="page in-page" v-if="listViewerMode">
    <list-viewer :user="user" :listId="openListId" @goBack="listViewerMode = false" @editList="editList" @update="getLists"/>
  </div>

    
</template>
<script>

import PersonalLists from "./shopping_list/PersonalLists";
import RecipeLists from "./shopping_list/RecipeLists";
import AddList from "./shopping_list/AddList";
import EditList from "./shopping_list/EditList";
import ListViewer from "./shopping_list/ListViewer.vue";

export default {
  props: ['logged', 'user'],
  components: {
    PersonalLists,
    RecipeLists,
    "add-list": AddList,
    "edit-list": EditList,
    "list-viewer": ListViewer
  },
  data() {
    return {
      selectedTab: 0,
      tabs: [
        "Рецепты",
        "Мои списки"
      ],
      addListMode: false,
      editListMode: false,
      listViewerMode: false,
      openListId: null,
      editListId: null,
      listsRecipe: null,
      listsPersonal: null,
      loading: true
    }
  },
  watch: {
    addListMode() {
      if(this.addListMode) {
        this.$emit("hideMenu", true);
      } else {
        this.$emit("hideMenu", false);
      }
    },
    listViewerMode() {
      if(this.listViewerMode) {
        this.$emit("hideMenu", true);
      } else {
        this.$emit("hideMenu", false);
      }
    }
  },
  mounted() {
    this.getLists();
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
    },
    openList(id) {
      this.listViewerMode = false;
      this.openListId = id;
      this.listViewerMode = true;
      this.getLists();
    },
    editList(id) {
      if(this.editListMode) {
        this.$emit("hideMenu", true);
      } else {
        this.$emit("hideMenu", false);
      }
      this.editListId = id;
      this.listViewerMode = false;
      this.editListMode = true;
    }
  },
};
</script>