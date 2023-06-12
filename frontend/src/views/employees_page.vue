<template>
  <div class="employees_page">
    <Modal :show="modalAdd" @close="closeAdd">
      <form class="form" @submit.prevent="addEmployee">
        <h4>Добавить работника</h4>
        <div v-if="error" class="error">{{ error }}</div>
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
            :options="shifts[employee.department_id]"
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
        <div
          v-if="
            employee.status == 1 || employee.status == 2 || employee.status == 3
          "
          class="form-field"
        >
          <span>Пароль</span>
          <input type="password" v-model="employee.password" />
        </div>
        <div class="form-button">
          <button>Добавить</button>
        </div>
      </form>
    </Modal>
    <Modal :show="modalUpdate" @close="closeUpdate">
      <form class="form" @submit.prevent="updateEmployee">
        <h4>Редактировать работника</h4>
        <div v-if="error" class="error">{{ error }}</div>
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
          <span>Отдел</span>
          <Multiselect
            v-model="employee.department_id"
            label="name"
            trackBy="id"
            valueProp="id"
            :options="departments"
          ></Multiselect>
        </div>
        <div class="form-field">
          <span>Смена</span>
          <Multiselect
            v-model="employee.shift_id"
            label="name"
            trackBy="id"
            valueProp="id"
            :options="shifts[employee.department_id]"
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
        <div
          v-if="
            employee.status == 1 || employee.status == 2 || employee.status == 3
          "
          class="form-field"
        >
          <span>Пароль</span>
          <input type="password" v-model="employee.password" />
        </div>
        <div class="form-button">
          <button>Сохранить</button>
        </div>
      </form>
    </Modal>
    <Modal :show="modalEdit" @close="closeEdit">
      <form class="form" @submit.prevent="editDepartment">
        <h4>Редактировать отдел</h4>
        <div v-if="error" class="error">{{ error }}</div>
        <div class="form-field">
          <span>Название</span>
          <input type="text" v-model="department.name" />
        </div>
        <div class="form-button">
          <button>Сохранить</button>
        </div>
      </form>
    </Modal>
    <Modal :show="modalConfirm" @close="closeConfirm">
      <form class="form" @submit.prevent="delDepartment">
        <div class="form-field">Вы уверены?</div>
        <div v-if="error" class="error">{{ error }}</div>
        <div class="form-button">
          <button>Удалить</button>
          <button type="button" @click="closeConfirm">Отменить</button>
        </div>
      </form>
    </Modal>
    <div class="content">
      <div class="content-header">
        <Add @click="showAdd">Добавить работника</Add>
        <BigUpdate @click="showEdit">Редактировать отдел</BigUpdate>
        <BigDelete
          @click="
            showConfirm(
              `http://localhost/api/departments/delete.php?id=${this.$route.params.department_id}`
            )
          "
          >Удалить отдел</BigDelete
        >
      </div>
      <Table
        :headers="headers"
        :data="data"
        @confirm="showConfirm"
        @update="update"
        @edit="edit"
      ></Table>
    </div>
  </div>
</template>

<script>
import Table from "@/components/Table.vue";
import Modal from "@/components/Modal.vue";
import Add from "@/components/Add.vue";
import BigDelete from "@/components/BigDelete.vue";
import BigUpdate from "@/components/BigUpdate.vue";
import Multiselect from "@vueform/multiselect";
import axios from "axios";

export default {
  components: { Table, Modal, Add, Multiselect, BigDelete, BigUpdate },

  data() {
    return {
      employee: {
        id: "",
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
        { id: "update" },
        { id: "delete" },
        { id: "name", name: "ФИО" },
        { id: "job_title", name: "Должность" },
        { id: "shift", name: "Смена" },
        { id: "status", name: "Уровень доступа" },
      ],
      data: [],
      employees: [],
      modalAdd: false,
      modalUpdate: false,
      modalEdit: false,
      modalConfirm: false,
      updated: false,
      shifts: {},
      statuses: [
        { id: 0, name: "Без доступа" },
        { id: 1, name: "Табельщик" },
        { id: 2, name: "Сотрудник отдела кадров" },
        { id: 3, name: "Сотрудник бухгалтерии" },
      ],
      error: "",
      departments: [],
      department: {},
    };
  },

  created() {
    this.getDepartments().then(() => {
      this.getEmployees(this.$route.params.department_id);
    });
  },

  methods: {
    async getDepartments() {
      await axios
        .get("http://localhost/api/departments/get.php")
        .then((response) => {
          this.departments = response.data;
          for (let department of this.departments) {
            this.getShifts(department.id);
          }
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
      for (let id in this.shifts[this.$route.params.department_id]) {
        if (
          this.shifts[this.$route.params.department_id][id].id ==
          employee.shift_id
        ) {
          employee.shift =
            this.shifts[this.$route.params.department_id][id].name;
          break;
        }
      }

      for (let status of this.statuses) {
        if (status.id == employee.status) {
          employee.status = status.name;
          break;
        }
      }

      let elem = [
        { id: "id", name: employee.id, hidden: true },
        { id: "number", name: employee.number },
        {
          id: "update",
          update: true,
          data_id: employee.id,
        },
        {
          id: "delete",
          delete: true,
          request: `http://localhost/api/employees/delete.php?id=${employee.id}`,
        },
        { id: "name", name: employee.name },
        { id: "job_title", name: employee.job_title },
        { id: "shift", name: employee.shift },
        { id: "status", name: employee.status },
      ];
      this.data.push(elem);
    },

    async addEmployee() {
      if (this.employee.status == 0) {
        this.employee.password = "";
      }

      if (this.employee.number == "") {
        this.error = 'Поле "Табельный номер" не может быть пустым';
      } else if (isNaN(this.employee.number)) {
        this.error = 'Поле "Табельный номер" должно быть числом';
      } else if (this.employee.surname == "") {
        this.error = 'Поле "Фамилия" не может быть пустым';
      } else if (this.employee.name == "") {
        this.error = 'Поле "Имя" не может быть пустым';
      } else if (this.employee.job_title == "") {
        this.error = 'Поле "Должность" не может быть пустым';
      } else if (this.employee.shift_id === null) {
        this.error = 'Поле "Смена" не может быть пустым';
      } else if (this.employee.status === null) {
        this.error = 'Поле "Уровень" не может быть пустым';
      } else {
        await axios
          .post("http://localhost/api/employees/signup.php", this.employee)
          .then(() => {
            this.update();
            this.closeAdd();
          })
          .catch((error) => {
            this.error = error.response.data.message;
          });
      }
    },

    async updateEmployee() {
      if (this.employee.status == 0) {
        this.employee.password = "";
      }

      if (this.employee.surname == "") {
        this.error = 'Поле "Фамилия" не может быть пустым';
      } else if (this.employee.name == "") {
        this.error = 'Поле "Имя" не может быть пустым';
      } else if (this.employee.job_title == "") {
        this.error = 'Поле "Должность" не может быть пустым';
      } else if (this.employee.department_id === null) {
        this.error = 'Поле "Отдел" не может быть пустым';
      } else if (this.employee.shift_id === null) {
        this.error = 'Поле "Смена" не может быть пустым';
      } else if (this.employee.status === null) {
        this.error = 'Поле "Уровень" не может быть пустым';
      } else {
        await axios
          .post("http://localhost/api/employees/update.php", this.employee)
          .then(() => {
            this.update();
            this.closeUpdate();
          })
          .catch((error) => {
            this.error = error.response.data.message;
          });
      }
    },

    async delDepartment() {
      axios
        .get(
          `http://localhost/api/departments/delete.php?id=${this.$route.params.department_id}`
        )
        .then((response) => {
          this.departments = response.data;
          this.$router.replace({
            name: "employees",
            params: {
              department_id: this.departments[0].id,
            },
          });
        })
        .catch((error) => {
          console.log(error.response.data.message);
          this.error = error.response.data.message;
        });
    },

    async editDepartment() {
      if (this.department.name == "") {
        this.error = 'Поле "Наименование" не может быть пустым';
      } else {
        axios
          .get(
            `http://localhost/api/departments/update.php?id=${this.$route.params.department_id}&name=${this.department.name}`
          )
          .then(() => {
            this.$emit("update");
            this.$emit("updateHeader");
            this.closeEdit();
          })
          .catch((error) => {
            this.error = error.response.data.message;
          });
      }
    },

    async getShifts(id) {
      await axios
        .get(`http://localhost/api/shifts/getOfDepartment.php?id=${id}`)
        .then((response) => {
          this.shifts[id] = response.data;
          if (id == this.$route.params.department_id) {
            this.employee.shift_id = this.shifts[id][0].id;
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    async edit(id) {
      await axios
        .get(`http://localhost/api/employees/getOne.php?id=${id}`)
        .then((response) => {
          this.employee = response.data;
          this.showUpdate();
        });
    },

    async getDepartment() {
      await axios
        .get(
          `http://localhost/api/departments/getOne.php?id=${this.$route.params.department_id}`
        )
        .then((response) => {
          this.department = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    update() {
      this.updated = true;
    },

    showAdd() {
      this.modalAdd = true;
    },

    closeAdd() {
      this.employee.number = "";
      this.employee.surname = "";
      this.employee.name = "";
      this.employee.patronymic = "";
      this.employee.job_title = "";
      this.employee.shift_id =
        this.shifts[this.$route.params.department_id][0].id;
      this.employee.status = 0;
      this.employee.password = "";
      this.error = "";
      this.modalAdd = false;
    },

    showUpdate() {
      this.modalUpdate = true;
    },

    closeUpdate() {
      this.employee.number = "";
      this.employee.surname = "";
      this.employee.name = "";
      this.employee.patronymic = "";
      this.employee.job_title = "";
      this.employee.shift_id =
        this.shifts[this.$route.params.department_id][0].id;
      this.employee.status = 0;
      this.employee.password = "";
      this.error = "";
      this.modalUpdate = false;
    },

    showEdit() {
      this.getDepartment();
      this.modalEdit = true;
    },

    closeEdit() {
      this.department.name = "";
      this.error = "";
      this.modalEdit = false;
    },

    showConfirm() {
      this.modalConfirm = true;
    },

    closeConfirm() {
      this.error = "";
      this.modalConfirm = false;
    },
  },

  watch: {
    updated() {
      this.data = [];
      if (this.updated == true) {
        this.getEmployees(this.$route.params.department_id);
        this.updated = false;
      }
    },

    "employee.department_id"() {
      this.employee.shift_id = this.shifts[this.employee.department_id][0].id;
    },
  },
};
</script>

<style scoped>
.table-wrapper {
  width: max-content;
  max-width: 100%;
}

.table {
  width: max-content;
  max-width: 100%;
}
</style>
