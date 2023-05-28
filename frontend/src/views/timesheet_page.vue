<template>
  <div class="timesheet_page">
    <div class="content">
      <Table
        :headers="headers"
        :data="data"
        :selected="true"
        @rowClick="route"
      ></Table>
    </div>
    <div class="content-bottom">
      <div></div>
      <button>Закрыть табель</button>
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
      employees: [],
      hours: [],
      headers: [
        { id: "id", name: "id", hidden: true },
        { id: "number", name: "Табельный номер" },
        { id: "name", name: "ФИО" },
        { id: "job_title", name: "Должность" },
      ],
      data: [],
    };
  },

  async created() {
    this.getUser().then(() =>
      this.getEmployees().then(() => {
        this.getDate();
      })
    );
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

    async getEmployees() {
      await axios
        .get(
          `http://localhost/api/employees/getOfDepartment.php?id=${this.user.department_id}`
        )
        .then((response) => {
          this.employees = response.data;
        })
        .then(() => {
          for (let index = 0; index < this.employees.length; index++) {
            this.getHours(this.employees[index].id, index);
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    getDate() {
      let date = new Date(this.$route.params.year, this.$route.params.month, 1);

      while (this.$route.params.month == date.getMonth()) {
        let newDate =
          this.normalizeNum(date.getDate()) +
          "." +
          this.normalizeNum(date.getMonth() + 1);
        this.headers.push({ id: "date", name: newDate });
        date = new Date(
          date.getFullYear(),
          date.getMonth(),
          date.getDate() + 1
        );
      }
    },

    getData(employee) {
      let date = new Date(this.$route.params.year, this.$route.params.month, 1);
      let elem = [
        { id: "id", name: employee.id, hidden: true },
        { id: "number", name: employee.number },
        { id: "name", name: employee.name },
        { id: "job_title", name: employee.job_title },
      ];

      while (this.$route.params.month == date.getMonth()) {
        let flag = false;
        for (let hour of employee.hours) {
          if (
            hour.date ==
            `${this.normalizeNum(date.getFullYear())}-${this.normalizeNum(
              date.getMonth() + 1
            )}-${this.normalizeNum(date.getDate())}`
          ) {
            elem.push({
              id: "date",
              name: hour.hours + hour.time_off,
            });
            flag = true;
            break;
          }
        }
        if (!flag) {
          elem.push({
            id: "date",
            name: date.getDay() == 6 || date.getDay() == 0 ? "В" : 0,
            background: date.getDay() == 6 || date.getDay() == 0 ? true : false,
          });
        }
        date = new Date(
          date.getFullYear(),
          date.getMonth(),
          date.getDate() + 1
        );
      }
      this.data.push(elem);
    },

    async getHours(id, index) {
      await axios
        .get(
          `http://localhost/api/hours/getOfMonth.php?id=${id}&start=${this.normalizeNum(
            this.$route.params.year
          )}-${this.normalizeNum(
            +this.$route.params.month + 1
          )}-01&end=${this.normalizeNum(
            this.$route.params.year
          )}-${this.normalizeNum(+this.$route.params.month + 2)}-01`
        )
        .then((response) => {
          this.employees[index].hours = response.data;
          this.getData(this.employees[index]);
        })
        .catch((error) => {
          console.log(error);
        });
    },

    normalizeNum(num) {
      if (num > 0 && num < 10) {
        return "0" + num;
      }

      return num;
    },

    route(id) {
      this.$router.push({ name: "employee", params: { id } });
    },

    logout() {
      localStorage.removeItem("token");
      this.$router.push("/login");
    },
  },
};
</script>

<style scoped>
.table-wrapper {
  max-height: calc(100vh - 170px);
}
</style>
