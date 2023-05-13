<template>
  <div class="department_page">
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
import json1 from "@/assets/json/employees.json";
import json2 from "@/assets/json/hours.json";

export default {
  components: { Table },

  data() {
    return {
      employees: json1,
      hours: json2,
      headers: [
        { id: "id", name: "Табельный номер" },
        { id: "name", name: "ФИО" },
        { id: "job_title", name: "Должность" },
      ],
      data: [],
    };
  },

  created() {
    this.getDate();
    this.getData();
    this.getDepartment();
  },

  methods: {
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

    getData() {
      for (let employee of this.employees) {
        let date = new Date(
          this.$route.params.year,
          this.$route.params.month,
          1
        );
        let elem = [
          { id: "id", name: employee.id },
          { id: "name", name: employee.name },
          { id: "job_title", name: employee.job_title },
        ];

        while (this.$route.params.month == date.getMonth()) {
          elem.push({ id: "date", name: json2[0].time });
          date = new Date(
            date.getFullYear(),
            date.getMonth(),
            date.getDate() + 1
          );
        }
        this.data.push(elem);
      }
    },

    normalizeNum(num) {
      if (num > 0 && num < 10) {
        return "0" + num;
      }

      return num;
    },

    route(id) {
      console.log(this.$route.path);
      this.$router.push({ name: "employee", params: { id } });
    },

    getDepartment() {},
  },
};
</script>

<style scoped></style>
