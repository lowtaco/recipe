<template>
  <div class="page">
    
    <div class="page-header no-border" id="slv-parent">
      <div class="header-w-button between">
        <div class="goBackButton" @click="$router.push('/shopping-lists')"><icon icon="back" size="small"/></div>
        <div class="list-viewer-shared"></div>
        <div class="popup-menu-button" @click="additionalPopupActive = true" id="slv-popup-btn">•••</div>
      </div>
    </div>
    
    <div class="page-content">
      <loader v-if="loading"/>

      <div class="list-viewer">
        <div class="list-viewer-header" @click="">
          <div class="sl-icon" :style="{'background-color': listInfo.color}" v-if="listInfo.icon"><span>{{ listInfo.icon }}</span></div>
          <div class="sl-picture" v-if="listInfo.picture">
            <img :src="listInfo.picture"/>
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
                <span>{{ item.amount }}{{ ' ' }}{{ item.unit.name }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="page-footer" :class="{absoluteBottom: addItemMode}">
      <button class="" @click="addItemMode = true">
        <icon icon="plus" size="small" />
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

    <Transition name="fade">
      <shared_options :id="id" :user="user" v-if="sharedOptionsMode" @goBack="sharedOptionsMode = false"/>
    </Transition>

    <confirm :settings="deleteConfirmSettings" @goBack="deleteConfirmMode = false" @confirm="deletePopUpConfirm" v-if="deleteConfirmMode"/>

  </div>
</template>
<script>
import AddListItem from "./AddListItem";
import shared_options from './shared_options'

export default {
  props: ['id', 'user'],
  components: {
    'add-list-item': AddListItem,
    shared_options
  },
  data() {
    return {
      loading: true,
      addItemMode: false,
      additionalPopupActive: false,
      listInfo: {},
      list: [],
      sharedOptionsMode: false,
      deleteConfirmMode: null,
      deleteConfirmSettings: {
        msg: "Вы уверены, что хотите удалить список?",
        yes: "Да",
        no: "Отмена"
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
    this.$emit("hideMenu", true);
    this.getList();
  },
  methods: {
    updateList() {
      console.log(this.list)
      axios.post('/update-list', {
        user: this.user.id,
        id: this.id,
        list: JSON.stringify(this.list)
      }).then((response) => {
        console.log(response)
      })
      this.$emit('update')
    },
    getList() {
      this.loading = true;
      axios.post('/get-list-info', {id: this.id}).then((response) => {
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
      axios.post('/delete-list', {id: this.id}).then(() => {
        this.$router.push('/shopping-lists')
      })
    },
    popupMenu(link) {
      if (link == 'editList') {
        this.$router.push('/edit-list/' + this.id);
      };
      if (link == 'deleteChecked') {
        let filteredList = _.filter(this.list , (i) => {
          return !i.checked;
        })
        this.list = filteredList;
        this.updateList();
      };  
      if (link == 'sharedOptions') {
        this.sharedOptionsMode = true;
      };
      if (link == 'share') {
        let token = утилиты.generateShareListToken(this.user, this.id)
        console.log(token)
      };
      if (link == 'delete') {
        this.deleteConfirmMode = true;
      };
      this.additionalPopupActive = false;
    }
  },
};
</script>