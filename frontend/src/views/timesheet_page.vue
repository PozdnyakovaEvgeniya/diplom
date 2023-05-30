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
    this.getUser().then(() => {
      this.getDates();
      this.get();
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

    async get() {
      await axios
        .post(
          `http://localhost/api/hours/get.php?id=${
            this.user.department_id
          }&start=${this.normalizeNum(
            this.$route.params.year
          )}-${this.normalizeNum(
            +this.$route.params.month + 1
          )}-01&end=${this.normalizeNum(
            this.$route.params.year
          )}-${this.normalizeNum(+this.$route.params.month + 2)}-01`
        )
        .then((response) => {
          console.log(response.data);
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
        for (let currentDate of employee.dates) {
          if (
            currentDate.date ==
            `${this.normalizeNum(date.getFullYear())}-${this.normalizeNum(
              date.getMonth() + 1
            )}-${this.normalizeNum(date.getDate())}`
          ) {
            elem.push({
              id: "date",
              name: currentDate.hours + currentDate.time_off,
              background: currentDate.date_status == 1 ? true : false,
            });
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
