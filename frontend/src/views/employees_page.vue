<template>
  <div class="employees_page">
    <Modal :show="modalAdd" @close="closeAdd">
      <form class="form" @submit.prevent="addEmployee">
        <h4>Добавить работника</h4>
        <div class="error">{{ error }}</div>
        <div class="form-field">
          <span>Табельный номер</span>
          <input type="text" v-model="employee.number" />
        </div>
        <div class="form-field">
          <span>Фамилия</span>
          <input type="text" v-model="employee.surname" />
        </div>
        <div class="form-field">
          <span>Имя</span>
          <input type="text" v-model="employee.name" />
        </div>
        <div class="form-field">
          <span>Отчество</span>
          <input type="text" v-model="employee.patronymic" />
        </div>
        <div class="form-field">
          <span>Должность</span>
          <input type="text" v-model="employee.job_title" />
        </div>
        <div class="form-field">
          <span>Смена</span>
          <Multiselect
            v-model="employee.shift_id"
            label="name"
            trackBy="id"
            valueProp="id"
            :options="shifts"
          ></Multiselect>
        </div>
        <div class="form-field">
          <span>Уровень доступа</span>
          <Multiselect
            v-model="employee.status"
            label="name"
            trackBy="id"
            valueProp="id"
            :options="statuses"
          ></Multiselect>
        </div>
        <div v-if="employee.status != 0" class="form-field">
          <span>Пароль</span>
          <input type="password" v-model="employee.password" />
        </div>
        <div class="form-button">
          <button>Добавить</button>
        </div>
      </form>
    </Modal>
    <div class="content">
      <div class="content-header">
        <Add @click="showAdd">Добавить работника</Add>
      </div>
      <Table :headers="headers" :data="data"></Table>
    </div>
  </div>
</template>

<script>
import Table from "@/components/Table.vue";
import Modal from "@/components/Modal.vue";
import Add from "@/components/Add.vue";
import Multiselect from "@vueform/multiselect";
import axios from "axios";

export default {
  components: { Table, Modal, Add, Multiselect },

  data() {
    return {
      employee: {
        number: "",
        surname: "",
        name: "",
        patronymic: "",
        job_title: "",
        department_id: this.$route.params.department_id,
        shift_id: "",
        status: 0,
        password: "",
      },
      headers: [
        { id: "id", name: "id", hidden: true },
        { id: "number", name: "Табельный номер" },
        { id: "delete" },
        { id: "name", name: "ФИО" },
        { id: "job_title", name: "Должность" },
        { id: "shift", name: "Смена" },
        { id: "status", name: "Уровень доступа" },
      ],
      data: [],
      employees: [],
      modalAdd: false,
      updated: false,
      shifts: [],
      statuses: [
        { id: 0, name: "Без доступа" },
        { id: 1, name: "Табельщик" },
        { id: 2, name: "Сотрудник отдела кадров" },
        { id: 3, name: "Сотрудник бухгалтерии" },
      ],
      error: "",
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
        {
          id: "delete",
          delete: true,
          request: `http://localhost/api/employee/delete.php?id=${employee.id}`,
        },
        { id: "name", name: employee.name },
        { id: "job_title", name: employee.job_title },
        { id: "shift", name: employee.shift_id },
        { id: "status", name: employee.status },
      ];
      this.data.push(elem);
    },

    async addEmployee() {
      await axios
        .post("http://localhost/api/employees/signup.php", this.employee)
        .then(() => {
          this.update();
          this.closeAdd();
        })
        .catch((error) => {
          console.log(error);
        });
    },

    async getShifts() {
      await axios
        .get(
          `http://localhost/api/shifts/getOfDepartment.php?id=${this.$route.params.department_id}`
        )
        .then((response) => {
          this.shifts = response.data;
          this.employee.shift_id = response.data[0].id;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    update() {
      this.updated = true;
    },

    showAdd() {
      this.getShifts();
      this.modalAdd = true;
    },

    closeAdd() {
      this.name = "";
      this.modalAdd = false;
    },
  },

  watch: {
    updated() {
      if (this.updated == true) {
        this.data = [];
        this.getEmployees(this.$route.params.department_id);
        this.updated = false;
      }
    },
  },
};
</script>

<style></style>
