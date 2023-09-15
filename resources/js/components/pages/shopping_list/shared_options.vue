<template>
  <div class="popup-menu-wrapper">
    <div class="popup-menu padding">
      <loader v-if="loading"/>
      <div class="switchbox">
        <span>Включить общий доступ</span>
        <input @click="updateSharedStatus" id="switchcheckbox" type="checkbox" :checked="isShared"/><label for="switchcheckbox" id="switch"></label>
      </div>

      <div class="divider line"/>

      <div class="shared-list-users">

        <div class="user" v-for="user in sharedUsers">
          <div class="info">
            <div class="picture">
              <img :src="user.picture">
            </div>
            <div class="name">
              <span>{{ user.first_name + ' ' + user.last_name }}</span>
              <p>@{{ user.nickname }}</p>
            </div>
          </div>
          <div class="remove-user" @click="removeSharedUser(user.id)">
            <icon icon="close" size="small"/>
          </div>
        </div>
       
      </div>

      <div class="add-new-shared-list-user">
        <div class="divider simple"><span>Добавить пользователя</span></div>
        <input type="text" v-model="inviteNickname" placeholder="Никнем">
        <button class="big" @click="sendInvite">Отправить приглашение</button>
      </div>

    </div>
    <div class="popup-menu-fake-bg" @click="$emit('goBack')"></div>
  </div>

  <Transition name="fade">
    <toast v-if="toastEnable" :msg="toastMsg"/>
  </Transition>

</template>
<script>
import axios from 'axios';


export default {
  props: ['id', 'user'],
  data() {
    return {
      isShared: null,
      inviteNickname: null,
      sharedUsers: [],
      sharedUsersIds: [],
      toastEnable: false,
      toastMsg: '',
      loading: true
    }
  },
  mounted() {
    this.getSharedStatus();
    this.getSharedUsers();
  },
  methods: {
    updateSharedStatus() {
      this.isShared = !this.isShared;

      axios.post('/updateSharedStatus', {
        list_id: this.id,
        status: this.isShared ? 1 : 0
      }).then(() => {
        this.getSharedStatus()
        if(this.isShared) {
          this.toast('Общий доступ включен')
        } else {
          this.toast('Общий доступ выключен')
        }
      })
    },
    getSharedStatus() {
      this.loading = true;
      axios.post('/getSharedListStatus', {
        list_id: this.id
      }).then((response) => {
        this.isShared = response.data;
        this.loading = false;
      })
    },  
    getSharedUsers() {
      this.loading = true;
      axios.post('/get-shared-shopping-list-users', {
        list_id: this.id
      }).then((response) => {
        this.sharedUsersIds = response.data;
        this.sharedUsers = [];
        if(this.sharedUsersIds.length) {
          _.forEach(this.sharedUsersIds, (user_id) => {
            axios.post('/get-user-info', {
              id: user_id
            }).then((response) => {
              this.sharedUsers.push(response.data[0])
              this.loading = false;
            })
          })
        }
      })
    },
    toast(msg) {
      this.toastMsg = msg;
      this.toastEnable = true;
      setTimeout(() => {
        this.toastEnable = false;
      }, 2000)
    },
    sendInvite() {
      this.loading = true;
      if(this.user.nickname != this.inviteNickname) {
        if (this.inviteNickname) {

          if(!this.isShared) {
            this.updateSharedStatus();
          }

          axios.post('/findUserByNickname', {
            nickname: this.inviteNickname
          }).then((response) => {
            
            if(response.data[0]) {
              const pending_user_id = response.data[0].id;

              axios.post('/findShareListPending', {
                list_id: this.id,
                user_id: pending_user_id,
                list_owner_id: this.user.id
              }).then((response) => {

                if(!response.data[0]) {
                  axios.post('/invite-user-to-list', {
                    list_id: this.id,
                    user_id: pending_user_id,
                    list_owner_id: this.user.id
                  }).then((response) => {
                    if(response.data) {
                      this.loading = false;
                      this.toast('Приглашение отправлено')
                    }
                  })
                } else {
                  this.loading = false;
                  this.toast('Приглашение уже отправлено')
                }
              })
            } else {
              this.loading = false;
              this.toast('Пользователь не найден')
            }
          })
        }
      } else {
        this.loading = false;
        this.toast('Нельзя пригласить самого себя')
      }
    },
    removeSharedUser(id) {
      this.loading = true;
      let updatedSharedUsers = _.filter(this.sharedUsersIds, (u) => {
        return u != id
      })

      axios.post('/updateSharedUsers', {
        list_id: this.id,
        shared_users: JSON.stringify(updatedSharedUsers)
      }).then(() => {
        this.getSharedUsers();
        this.loading = false;
      })
    }
  }
};
</script>