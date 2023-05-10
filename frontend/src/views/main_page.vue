<template>
  <div class="department_page">
    <Header :name="department"></Header>
    <router-view :key="$route.path"></router-view>
  </div>
</template>

<script>
import Header from "@/components/Header.vue";
import Table from "@/components/Table.vue";
import json1 from "@/assets/json/employees.json";
import json2 from "@/assets/json/hours.json";

export default {
  components: { Header },

  data() {
    return {
      department: "Отдел №1",
    };
  },
}
</script>

<style>
  .table-wrapper {
    height: calc(100vh - 170px);
  }
</style>
