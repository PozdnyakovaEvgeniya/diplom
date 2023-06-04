<template>
  <div class="main_page">
    <Header :name="department.name"></Header>
    <router-view :key="$route.path"></router-view>
  </div>
</template>

<script>
import Header from "@/components/Header.vue";
import Table from "@/components/Table.vue";
import axios from "axios";

export default {
  components: { Header, Table },

  data() {
    return {
      department: {},
    };
  },

  created() {
    this.getDepartment(this.$route.params.department_id);
  },

  methods: {
    async getDepartment(id) {
      await axios
        .get(`http://localhost/api/departments/getOne.php?id=${id}`)
        .then((response) => {
          this.department = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },

  watch: {
    "$route.params.department_id"() {
      this.getDepartment(this.$route.params.department_id);
    },
  },
};
</script>

<style></style>
