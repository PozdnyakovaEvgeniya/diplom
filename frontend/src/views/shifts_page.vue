<template>
  <div class="shifts_page">
    <div class="content">
      <h4>Смены</h4>
      <ol>
        <li v-for="(shift, index) in shifts" :key="index">{{ shift.name }}</li>
      </ol>
    </div>
  </div>
</template>

<script>
import Table from "@/components/Table.vue";
import axios from "axios";

export default {
  components: { Table },

  data() {
    return {
      user: {},
      shifts: [],
    };
  },

  async created() {
    this.getUser().then(() => {
      this.getShifts();
    });
  },

  methods: {
    async getUser() {
      await axios
        .post("http://localhost/api/employees/getUser.php", {
          token: localStorage.getItem("token"),
        })
        .then((response) => {
          this.user = response.data;
        })
        .catch((error) => {
          this.logout();
        });
    },

    async getShifts() {
      await axios
        .get(
          `http://localhost/api/shifts/getOfDepartment.php?id=${this.user.department_id}`
        )
        .then((response) => {
          this.shifts = response.data;
        })
        .catch((error) => {
          this.logout();
        });
    },

    logout() {
      localStorage.removeItem("token");
      this.$router.push("/login");
    },
  },
};
</script>

<style scoped></style>
