<template>
  <div class="shifts_page">
    <div class="content">
      <h4>Смены</h4>
      <ol>
        <li v-for="(shift, index) in shifts" :key="index">{{ shift.name }}</li>
      </ol>

      <form class="form" @submit.prevent="addShift(user.department_id)">
        <h4>Добавить смену</h4>
        <div class="error">{{ error }}</div>
        <div class="form-field">
          <span>Название</span>
          <input type="text" v-model="name" />
        </div>
        <div class="form-button">
          <button>Добавить</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      user: {},
      shifts: [],
      name: "",
      error: "",
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
        .catch(() => {
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
        .catch(() => {
          this.logout();
        });
    },

    async addShift(department_id) {
      await axios
        .post("http://localhost/api/shifts/add.php", {
          name: this.name,
          department_id,
        })
        .then(() => {
          this.getShifts();
        })
        .catch((error) => {
          console.log(error);
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
