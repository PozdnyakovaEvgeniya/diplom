<template>
  <div class="main_page">
    <Header></Header>
    <router-view :key="$route.path"></router-view>
  </div>
</template>

<script>
import Header from "@/components/Header.vue";

export default {
  components: { Header },
};
</script>

<style></style>
