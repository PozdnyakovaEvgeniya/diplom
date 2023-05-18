<template>
  <div class="department_page">
    <Header></Header>
    <router-view :key="$route.path"></router-view>
  </div>
</template>

<script>
import Header from "@/components/Header.vue";

export default {
  components: { Header },

  data() {
    return {
      user: "",
    };
  },
};
</script>

<style>
.table-wrapper {
  height: calc(100vh - 170px);
}
</style>
