<template>
  <div class="department_page">
    <Header :name="department"></Header>
    <div class="content">
      <Table :columns="columns" :rows="rows" :link="'/employer/'"></Table>
    </div>
  </div>
</template>

<script>
import Header from "@/components/Header.vue";
import Table from "@/components/Table.vue";
import json1 from "@/assets/json/employers.json";
import json2 from "@/assets/json/hours.json";

export default {
  components: { Header, Table },

  data() {
    return {
      employers: json1,
      hours: json2,
      columns: [
        { id: "id", name: "Табельный номер" },
        { id: "name", name: "ФИО" },
        { id: "job_title", name: "Должность" },
      ],
      rows: [],
      department: "",
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
        this.columns.push({ id: "date", name: newDate });
        date = new Date(
          date.getFullYear(),
          date.getMonth(),
          date.getDate() + 1
        );
      }
    },

    getData() {
      for (let employer of this.employers) {
        let date = new Date(
          this.$route.params.year,
          this.$route.params.month,
          1
        );
        let row = [
          { id: "id", name: employer.id },
          { id: "name", name: employer.name },
          { id: "job_title", name: employer.job_title },
        ];

        while (this.$route.params.month == date.getMonth()) {
          row.push({ id: "date", name: json2[0].time });
          date = new Date(
            date.getFullYear(),
            date.getMonth(),
            date.getDate() + 1
          );
        }
        this.rows.push(row);
      }
    },

    normalizeNum(num) {
      if (num > 0 && num < 10) {
        return "0" + num;
      }

      return num;
    },

    getDepartment() {
      
    },
  },
};
</script>

<style></style>
