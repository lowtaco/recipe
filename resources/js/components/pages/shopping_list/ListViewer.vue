<template>
  <div class="page add-shopping-list no-padding">
    

    <div class="page-header no-border" id="slv-parent">
      <div class="header-w-button between">
        <div class="goBackButton" @click="$emit('goBack')"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M9.578 17.137a.625.625 0 0 1-.882-.058l-5.833-6.667a.625.625 0 0 1 0-.823l5.833-6.667a.625.625 0 1 1 .94.823l-4.925 5.63h11.956a.625.625 0 0 1 0 1.25H4.711l4.926 5.63a.625.625 0 0 1-.058.882Z" fill="#030D45"/></svg></div>
        <div class="list-viewer-shared"></div>
        <div class="popup-menu-button" @click="additionalPopupActive = true" id="slv-popup-btn">•••</div>
      </div>
    </div>

    
    <div class="page-content">
      <loader v-if="loading"/>

      <div class="list-viewer">

        <div class="list-viewer-header">
          <div class="lvh-icon">
            <span>{{ listInfo.icon }}</span>
          </div>
          <div class="lvh-title">
            <h3>{{ listInfo.name }}</h3>
          </div>
        </div>
        
        <div class="shopping-list">
          <div class="shopping-list-item" v-for="item in list" @click="checkItem(item)">
            <div class="sli-main">
              <checkbox :checked="item.checked"/>
              <span :class="{checked: item.checked}">{{ item.name }}</span>
            </div>
            <div class="sli-secondary">
              <div class="sl-amount">
                <span>{{ item.amount }}{{ ' ' }}{{ item.unit }}</span>
              </div>
            </div>
          </div>
        </div>

      </div>
    
    </div>

    <div class="page-footer" :class="{absoluteBottom: addItemMode}">
      <button class="" @click="addItemMode = true">
        <svg width="20" height="20" viewBox="0 0 0.6 0.6" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M.3.1a.025.025 0 0 1 .025.025v.15h.15a.025.025 0 1 1 0 .05h-.15v.15a.025.025 0 1 1-.05 0v-.15h-.15a.025.025 0 1 1 0-.05h.15v-.15A.025.025 0 0 1 .3.1z" fill="black"/></svg>
        <span>Добавить продукт</span>
      </button>
    </div>

    <Transition name="slide-bottom">
      <div class="page-footer-popup" v-if="addItemMode">
        <div class="add-shopping-list-item">
            <add-list-item :list="list" @goBack="addItemMode = false" @update="updateList"/>
        </div>
      </div>
    </Transition>

    <Transition name="fade">
    <popup-menu :items="popupMenuItems" type="element" elId="slv-popup-btn" parentId="slv-parent"  @goBack="additionalPopupActive = false" @callback="popupMenu" v-if="additionalPopupActive"/>
    </Transition>

    <confirm :settings="deleteConfirmSettings" @goBack="deleteConfirmMode = false" @confirm="deletePopUpConfirm" v-if="deleteConfirmMode"/>

  </div>
</template>
<script>
import AddListItem from "./AddListItem"

export default {
  props: ['listId', 'user'],
  components: {
    'add-list-item': AddListItem
  },
  data() {
    return {
      loading: true,
      addItemMode: false,
      additionalPopupActive: false,
      listInfo: {},
      list: [],
      deleteConfirmMode: null,
      deleteConfirmSettings: {
        msg: "Вы уверены?",
        yes: "Как никогда!",
        no: "Не, не уверен"
      },
      popupMenuItems: [
        {
          "name": "Редактировать список",
          "type": "normal",
          "link": "editList"
        },
        {
          "name": "Удалить отмеченные",
          "type": "normal",
          "link": "deleteChecked"
        },
        {
          "name": "Общий доступ",
          "type": "shared",
          "link": "sharedOptions",
        },
        {
          "name": "Поделиться",
          "type": "share",
          "link": "share"
        },
        {
          "name": "Удалить список",
          "type": "delete",
          "link": "delete"
        },
      ]
    }
  },
  computed: {

  },
  mounted() {
    this.getList();
  },
  methods: {
    updateList() {
      console.log(this.list)
      axios.post('/update-list', {
        user: this.user.email,
        id: this.listId,
        list: JSON.stringify(this.list)
      }).then((response) => {
        console.log(response)
      })
      this.$emit('update')
    },
    getList() {
      this.loading = true;
      axios.post('/get-list-info', {id: this.listId}).then((response) => {
        this.listInfo = response.data[0];
        this.list = JSON.parse(response.data[0].list);
        console.log(this.list)
        this.loading = false;
      })
    },
    checkItem(item) {
      item.checked = !item.checked;
      this.updateList();
    },
    deletePopUpConfirm() {
      this.deleteConfirmMode = false;
      axios.post('/delete-list', {id: this.listId}).then((response) => {
        console.log(response);
        this.$emit('update');
        this.$emit('goBack')
      })
    },
    popupMenu(link) {
      if (link == 'editList') {
        this.$emit('editList', this.listId);
      };
      if (link == 'deleteChecked') {
        let filteredList = _.filter(this.list , (i) => {
          return !i.checked;
        })
        this.list = filteredList;
        this.updateList();
      };  
      if (link == 'sharedOptions') {

      };
      if (link == 'share') {

      };
      if (link == 'delete') {
        this.deleteConfirmMode = true;
      };
      this.additionalPopupActive = false;
    }
  },
};
</script>