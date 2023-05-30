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
        .catch(() => {
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
            this.getDates(
              this.employees[index].shift_id,
              index,
              this.employees[index].id
            );
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
        for (let index = 0; index < employee.dates.length; index++) {
          if (
            dates[index].date ==
            `${this.normalizeNum(date.getFullYear())}-${this.normalizeNum(
              date.getMonth() + 1
            )}-${this.normalizeNum(date.getDate())}`
          ) {
            elem.push({
              id: "date",
              name: dates[index].hours + dates[index].time_off,
            });
            flag = true;
            break;
          }
        }
        date = new Date(
          date.getFullYear(),
          date.getMonth(),
          date.getDate() + 1
        );
      }
      this.data.push(elem);
    },

    async getDates(shift_id, index, employee_id) {
      await axios
        .get(
          `http://localhost/api/dates/getOfMonth.php?id=${shift_id}&start=${this.normalizeNum(
            this.$route.params.year
          )}-${this.normalizeNum(
            +this.$route.params.month + 1
          )}-01&end=${this.normalizeNum(
            this.$route.params.year
          )}-${this.normalizeNum(+this.$route.params.month + 2)}-01`
        )
        .then((response) => {
          this.employees[index].dates = response.data;
        })
        .then(() => {
          for (let i = 0; i < this.employees[index].dates.length; i++) {
            this.getHours(
              employee_id,
              this.employees[index].dates[i].id,
              index,
              i
            );
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    async getHours(employee_id, date_id, index1, index2) {
      await axios
        .get(
          `http://localhost/api/hours/getOne.php?employee_id=${employee_id}&date_id=${date_id}`
        )
        .then((response) => {
          for (let key in response.data) {
            this.employees[index1].dates[index2].push(response.data[key]);
            this.getData(this.employees[index1]);
          }
        })
        .catch(() => {
          this.employees[index1].dates[index2].hours = 0;
          this.employees[index1].dates[index2].overtime = 0;
          this.employees[index1].dates[index2].time_off = 0;
          this.employees[index1].dates[index2].status = 0;
          this.getData(this.employees[index1]);
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
