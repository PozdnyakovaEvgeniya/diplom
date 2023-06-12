<template>
  <div class="timesheet_page">
    <div class="content">
      <Table
        v-if="user.status != 3 || closed"
        :headers="headers"
        :data="data"
        :selected="true"
        @rowClick="route"
      ></Table>
    </div>
    <div class="content-bottom">
      <div></div>
      <button v-if="!closed && user.status != 3" @click="close">
        Закрыть табель
      </button>
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
      headers: [
        { id: "id", name: "id", hidden: true },
        { id: "number", name: "Табельный номер" },
        { id: "name", name: "ФИО" },
        { id: "job_title", name: "Должность" },
      ],
      data: [],
      closed: false,
      department_id: "",
    };
  },

  async created() {
    this.getUser().then(() => {
      this.getClosed();
      this.getDates();
      this.get();
    });
  },

  methods: {
    getDepartmentId() {
      if (this.user.status == 1) {
        this.department_id = this.user.department_id;
      } else if (this.user.status == 3) {
        this.department_id = this.$route.params.id;
      }
    },

    async getClosed() {
      await axios
        .get(
          `http://localhost/api/months/get.php?department_id=${
            this.department_id
          }&year=${this.$route.params.year}&month=${
            +this.$route.params.month + 1
          }`
        )
        .then((response) => {
          if (response.data.count != 0) {
            this.closed = true;
          }
        });
    },

    async close() {
      await axios
        .post("http://localhost/api/months/add.php", {
          department_id: this.department_id,
          year: this.$route.params.year,
          month: +this.$route.params.month + 1,
        })
        .then(() => {
          this.closed = true;
        });
    },

    async getUser() {
      await axios
        .post("http://localhost/api/employees/getUser.php", {
          token: localStorage.getItem("token"),
        })
        .then((response) => {
          this.user = response.data;
          this.getDepartmentId();
        })
        .catch(() => {
          this.logout();
        });
    },

    async get() {
      await axios
        .post(
          `http://localhost/api/hours/get.php?id=${
            this.department_id
          }&start=${this.normalizeNum(
            this.$route.params.year
          )}-${this.normalizeNum(
            +this.$route.params.month + 1
          )}-01&end=${this.normalizeNum(
            this.$route.params.year
          )}-${this.normalizeNum(+this.$route.params.month + 2)}-01`
        )
        .then((response) => {
          for (let employee of response.data) {
            this.getData(employee);
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    getDates() {
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
      this.headers.push({ id: "total", name: "Итого" });
    },

    getData(employee) {
      let date = new Date(this.$route.params.year, this.$route.params.month, 1);
      let elem = [
        { id: "id", name: employee.id, hidden: true },
        { id: "number", name: employee.number },
        { id: "name", name: employee.name },
        { id: "job_title", name: employee.job_title },
      ];
      let totalPlan = 0;
      let totalFact = 0;
      while (this.$route.params.month == date.getMonth()) {
        let flag = false;
        for (let currentDate of employee.dates) {
          if (
            currentDate.date ==
            `${this.normalizeNum(date.getFullYear())}-${this.normalizeNum(
              date.getMonth() + 1
            )}-${this.normalizeNum(date.getDate())}`
          ) {
            totalPlan += currentDate.plan_hours;
            totalFact += currentDate.hours;
            elem.push({
              id: "date",
              name: [
                currentDate.employee_status == ""
                  ? currentDate.date_status
                  : currentDate.employee_status,
                currentDate.plan_hours,
                currentDate.hours,
                currentDate.date,
              ],
              hours: true,
              background: currentDate.date_status == 1 ? true : false,
            });
            flag = true;
            break;
          }
        }
        if (!flag) {
          elem.push({
            id: "date",
            name: 0,
          });
        }

        date = new Date(
          date.getFullYear(),
          date.getMonth(),
          date.getDate() + 1
        );
      }
      elem.push({
        id: "total",
        name: ["total", totalPlan, totalFact],
        hours: true,
      });
      this.data.push(elem);
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
  max-height: calc(100vh - 251px);
}
</style>
