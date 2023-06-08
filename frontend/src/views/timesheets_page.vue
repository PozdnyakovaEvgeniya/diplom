<template>
  <div class="department_page">
    <div class="nav">
      <router-link
        v-for="department in departments"
        :key="department.id"
        :to="{ name: 'accountant-timesheet', params: { id: department.id } }"
      >
        {{ department.name }}
      </router-link>
    </div>
    <router-view :key="$route.path"></router-view>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      departments: [],
    };
  },

  created() {
    this.getDepartments();
  },

  methods: {
    async getDepartments() {
      await axios
        .get("http://localhost/api/departments/get.php")
        .then((response) => {
          this.departments = response.data;
        });
    },
  },
};
</script>

<style scoped></style>
