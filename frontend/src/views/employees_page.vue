<template>
  <div class="employees_page">
    <div class="content">
      <Table :headers="headers" :data="data"></Table>
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
      headers: [
        { id: "id", name: "id", hidden: true },
        { id: "number", name: "Табельный номер" },
        { id: "name", name: "ФИО" },
        { id: "job_title", name: "Должность" },
        { id: "shift", name: "Смена" },
        { id: "status", name: "Уровень доступа" },
      ],
      data: [],
      employees: [],
    };
  },

  created() {
    this.getEmployees(this.$route.params.department_id);
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

    async getEmployees(id) {
      await axios
        .get(`http://localhost/api/employees/getOfDepartment.php?id=${id}`)
        .then((response) => {
          this.employees = response.data;
          for (let employee of response.data) {
            this.getData(employee);
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    getData(employee) {
      let elem = [
        { id: "id", name: employee.id, hidden: true },
        { id: "number", name: employee.number },
        { id: "name", name: employee.name },
        { id: "job_title", name: employee.job_title },
        { id: "shift", name: employee.shift_id },
        { id: "status", name: employee.status },
      ];
      this.data.push(elem);
    },
  },
};
</script>

<style></style>
