<template>
  <div class="verified">
    <div class="item" @click="toast = !toast" id="verified-reference">
      <icon icon="verified" size="tiny"/>
    </div>
    
    <Transition name="fade">
      <div class="verified-toast" :style="{'top': i_top, 'left': i_right}" v-if="toast">
        <p>Этот профиль официально подтвержден</p>
      </div>
    </Transition>
    
  </div>
</template>
<script>

export default {
  props: ['select'],
  data() {
    return {
      toast: false,
      i_top: 0,
      i_left: 0
    }
  },
  watch: {
    toast() {
      if(this.toast) {
        let x = document.getElementById('verified-reference')
        let rect = x.getBoundingClientRect()
        this.i_left =  rect.left + 'px';
        this.i_top = rect.top + 20 + 'px';

        setTimeout(() => {
          this.toast = false;
        }, 2000)
      }
    }
  },
  methods: {

  }
};
</script>
<style>
.verified {
  display: flex;
  align-items: center;
  justify-content: center;
}

.verified-toast {
  position: absolute;
  background-color: rgba(0, 0, 0, 0.8);
  color: white;
  padding: 8px 16px;
  border-radius: 10px;
  box-sizing: border-box;
}

.verified-toast p {
  margin: 0;
  font-size: 14px;
}
</style>