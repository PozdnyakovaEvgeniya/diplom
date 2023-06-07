<template>
  <div class="main_page">
    <Header :name="department.name"></Header>
    <router-view
      @update="$emit('update')"
      @updateHeader="update"
      :key="$route.path"
    ></router-view>
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
      updated: false,
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

    update() {
      this.updated = true;
    },
  },

  watch: {
    "$route.params.department_id"() {
      this.getDepartment(this.$route.params.department_id);
    },
    updated() {
      if (this.updated == true) {
        this.getDepartment(this.$route.params.department_id);
        this.updated = false;
      }
    },
  },
};
</script>

<style></style>
