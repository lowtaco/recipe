<template>
  <div class="popup-menu-wrapper">
    <div class="popup-menu padding">
      <div class="switchbox">
        <span>Включить общий доступ</span>
        <input @click="updateSharedStatus" id="switchcheckbox" type="checkbox" :checked="isShared"/><label for="switchcheckbox" id="switch"></label>
      </div>

      <div class="divider line"/>

      <div class="shared-list-users">
        <div class="user">
          <div class="info">
            <div class="picture">

            </div>
            <div class="name">
              <span>paintedfriend</span>
            </div>
          </div>
          <div class="remove-user">
            <icon icon="close" size="small"/>
          </div>
        </div>
        <div class="user">
          <div class="info">
            <div class="picture">

            </div>
            <div class="name">
              <span>paintedfriend</span>
            </div>
          </div>
          <div class="remove-user">
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
      toastEnable: false,
      toastMsg: ''
    }
  },
  watch: {
  },
  mounted() {
    this.getSharedStatus()
  },
  methods: {
    updateSharedStatus() {
      this.isShared = !this.isShared;

      axios.post('/updateSharedStatus', {
        list_id: this.id,
        status: this.isShared ? 1 : 0
      }).then((response) => {
        console.log(response)
        this.getSharedStatus()
      })
    },
    getSharedStatus() {
      axios.post('/getSharedListStatus', {
        list_id: this.id
      }).then((response) => {
        console.log(response)
        this.isShared = response.data
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
      if (this.inviteNickname) {
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
                    this.toast('Приглашение отправлено')
                  }
                })
              } else {
                this.toast('Приглашение уже отправлено')
              }
            })

          } else {
            this.toast('Пользователь не найден')
          }

        })
      }
    }
  }
};
</script>