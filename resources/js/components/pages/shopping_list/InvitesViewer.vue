<template>
  <div class="page add-shopping-list">
    
    <div class="page-header no-border">
      <div class="header-w-button">
        <div class="goBackButton" @click="$router.push('/shopping-lists')"><icon icon="back" size="small"/></div>
        <h1>Приглашения</h1>
      </div>
    </div>

    <div class="page-content">
      <loader v-if="loading"/>
      <div class="list-invites">
        <div class="invite" v-for="invite in invites">

          <div class="info" v-if="invite.list_info">
            <div class="picture" v-if="invite.list_info.picture">
              <img :src="invite.list_info.picture">
            </div>
            <div class="sl-icon" :style="{'background-color': invite.list_info.color}" v-if="invite.list_info.icon">
              <span>{{ invite.list_info.icon }}</span>
            </div>
            <div class="text">
              <div class="name">
                <span>{{ invite.list_info.name }}</span>
              </div>
              <div class="owner" v-if="invite.owner_info">
                <span>@{{ invite.owner_info.nickname }}</span>
              </div>
            </div>
          </div>

          <div class="action-buttons">
            <div class="item" @click="declineInvite(invite.id)">
              <icon icon="close" size="tiny"></icon>
              <span>Отказаться</span>
            </div>
            <div class="item" @click=aproveInvite(invite.id)>
              <icon icon="checkbox" size="small"></icon>
              <span>Принять</span>
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
  props: ['user'],
  data() {
    return {
      loading: true,
      invites: []
    }
  },
  mounted() {
    this.getInvites();
  },
  methods: {
    getInvites() {
      this.loading = true;

      // Получаем список приглашений в списки покупок
      axios.post('/get-shopping-list-invites', {
        user_id: this.user.id
      }).then((response) => {
        if(response.data.length) {
          this.invites = response.data;

          // Цикл по каждому инвайту
          _.forEach(response.data, (invite, index) => {
            // Получаем информацию о списке покупок из инвайта
            axios.post('/get-list-info', {id: invite.list_id}).then((response) => {
              let listInfo = response.data[0];
              this.invites[index].list_info = listInfo

              // Получаем информацию о приглашающем пользователе
              axios.post('/get-user-info', {
                id: invite.list_owner_id
              }).then((response) => {
                this.invites[index].owner_info = response.data[0];
                this.loading = false;
              })
            })
            
          })
        } else {
          // Если ивайтов нет, создаем переадресацию на страницу со списками покупок
          this.$router.push('/shopping-lists');
        }
      })
     
    },
    declineInvite(id) {
      // Удаляем pending инвайт
      axios.post('/declineInviteList', {
        invite_id: id
      }).then(() => {
        this.getInvites();
      })
    },
    aproveInvite(id) {
      let invite = _.find(this.invites, {id: id});
      if (invite) {
        let shared_users = JSON.parse(invite.list_info.shared_users);
        
        if(!shared_users) {
          shared_users = [];
        }

        shared_users.push(invite.user_id);

        // Добавляем текущего пользователя в shared_users списка покупок и удаляем pending инвайт
        axios.post('/aproveInviteList', {
          invite_id: id,
          shared_users: JSON.stringify(shared_users) 
        }).then(() => {
          this.getInvites();
        })  
      }
      
    }
  },
};
</script>