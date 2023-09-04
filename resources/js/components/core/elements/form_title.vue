<template>
  <div class="form-title">
    <span>{{ title }}</span>
  </div>
</template>
<script>

export default {
  props: ['title']
};
</script>
<style>

.form-title {
  padding: 0 0px;
  padding-top: 8px;
  margin-bottom: 0px;
}

.form-title span {
  font-size: 18px;
  font-weight: 700;
}

</style>