<template>
  <div class="page">
    <div class="header">
      <div class="goBack">
        <icon icon="back"/>
      </div>
      <input type="text" placeholder="Название поста"/>
    </div>
    

    <h1>Atricle Editor</h1>

  </div>
</template>
<script>

export default {
  props: ['user'],
  data() {
    return {
      
    }
  },
  mounted() {
    
  },
  methods: {
    
  }
};
</script>
<style scoped>

.page {
  box-sizing: border-box;
}

.header {
  position: relative;
  display: inline-flex;
  align-items: center;
  padding: 0 16px;
  height: 48px;
  width: 100vw;
  gap: 16px;
  box-sizing: border-box;
}

.header input {
  height: 32px;
  border-radius: 10px;
  width: -webkit-fill-available;
  flex-shrink: 1;
  box-sizing: border-box;
}

.header button {
  flex-shrink: 0;
}


</style>