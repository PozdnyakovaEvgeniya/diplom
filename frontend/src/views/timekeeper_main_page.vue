<template>
  <div class="main_page">
    <Header :name="department.name"></Header>
    <router-view :key="$route.path"></router-view>
  </div>
</template>

<script>
import Header from "@/components/Header.vue";
import axios from "axios";

export default {
  components: { Header },

  data() {
    return {
      department: {},
    };
  },

  created() {
    this.getUser();
  },

  methods: {
    async getUser() {
      await axios
        .get(
          `http://localhost/api/employees/getUser.php?token=${localStorage.getItem(
            "token"
          )}`
        )
        .then((response) => {
          this.getDepartment(response.data.department_id);
        })
        .catch(() => {
          this.logout();
        });
    },

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
};
</script>

<style></style>
