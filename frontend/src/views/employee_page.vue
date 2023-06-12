<template>
  <div class="employee_page">
    <Modal :show="modalAdd" @close="closeAdd">
      <form class="form" @submit.prevent="addPeriod">
        <h4>Добавить период</h4>
        <div class="error">{{ error }}</div>
        <div class="form-field">
          <span>Название периода</span>
          <Multiselect
            v-model="status_id"
            label="name"
            trackBy="id"
            valueProp="id"
            :options="statuses"
          ></Multiselect>
        </div>
        <div class="form-field">
          <span>Начало периода</span>
          <input type="date" v-model="start" />
        </div>
        <div class="form-field" v-if="hourly == 1">
          <span>Количество часов</span>
          <input type="text" v-model="hours" />
        </div>
        <div class="form-field" v-else>
          <span>Окончание периода</span>
          <input type="date" v-model="end" />
        </div>
        <div class="form-button">
          <button>Добавить</button>
        </div>
      </form>
    </Modal>
    <Modal :show="modalUpd" @close="closeUpd">
      <form class="form" @submit.prevent="updShift">
        <h4>Редактировать смену</h4>
        <div v-if="error" class="error">{{ error }}</div>
        <div class="form-field">
          <span>Смена</span>
          <Multiselect
            v-model="shift_id"
            label="name"
            trackBy="id"
            valueProp="id"
            :options="shifts"
          ></Multiselect>
        </div>
        <div class="form-button">
          <button>Сохранить</button>
        </div>
      </form>
    </Modal>
    <div class="content">
      <div class="content-header">
        <Back
          :to="{
            name: 'timesheet',
            params: {
              year: this.$route.params.year,
              month: this.$route.params.month,
            },
          }"
        ></Back>
        <div class="employee">
          <h4>{{ employee.fullName }}</h4>
          <div>{{ employee.job_title }}</div>
        </div>
      </div>
      <div class="content-header">
        <Add v-if="!closed" @click="showAdd">Добавить период</Add>
      </div>
      <Table
        v-if="data.length != 0"
        :headers="headers"
        :data="data"
        @update="update"
      ></Table>
      <div class="shift">
        Смена: {{ this.shift.name }} <Update @click="showUpd"></Update>
      </div>
      <div class="overtime">
        Переработанные часы: {{ this.employee.overtime }}
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Multiselect from "@vueform/multiselect";
import Add from "@/components/Add.vue";
import Back from "@/components/Back.vue";
import Modal from "@/components/Modal.vue";
import Table from "@/components/Table.vue";
import Update from "@/components/Update.vue";

export default {
  components: {
    Back,
    Multiselect,
    Add,
    Modal,
    Table,
    Update,
  },

  data() {
    return {
      user: {},
      employee: {},
      statuses: [],
      status_id: "",
      modalAdd: false,
      start: "",
      end: "",
      headers: [
        { id: "name", name: "Наименование периода" },
        { id: "delete" },
        { id: "start", name: "Начало периода" },
        { id: "end", name: "Окончание периода" },
        { id: "hours", name: "Количество часов" },
      ],
      data: [],
      updated: false,
      hours: "",
      closed: false,
      hourly: 0,
      shift: {},
      shifts: [],
      modalUpd: false,
      shift_id: "",
    };
  },

  created() {
    this.getUser().then(() => {
      this.getClosed();
      this.getEmployee().then(() => {
        this.getShift();
      });
      this.getStatuses();
      this.getPeriods();
      this.getShifts();
    });
  },

  methods: {
    async getShifts() {
      await axios
        .get(
          `http://localhost/api/shifts/getOfDepartment.php?id=${this.user.department_id}`
        )
        .then((response) => {
          this.shifts = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    async getShift() {
      await axios
        .get(
          `http://localhost/api/shifts/getOne.php?id=${this.employee.shift_id}`
        )
        .then((response) => {
          this.shift = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    async getStatuses() {
      await axios
        .get("http://localhost/api/statuses/get.php")
        .then((response) => {
          this.statuses = response.data;
          this.status_id = response.data[0].id;
        })
        .catch((error) => {
          console.log(error);
        });
    },

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

    async getClosed() {
      await axios
        .get(
          `http://localhost/api/months/get.php?department_id=${
            this.user.department_id
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

    async getEmployee() {
      await axios
        .get(
          `http://localhost/api/employees/getOne.php?id=${this.$route.params.id}`
        )
        .then((response) => {
          this.employee = response.data;
          this.shift_id = response.data.shift_id;
        });
    },

    async getPeriods() {
      await axios
        .get(
          `http://localhost/api/periods/getOfMonth.php?id=${
            this.$route.params.id
          }&start=${this.normalizeNum(
            this.$route.params.year
          )}-${this.normalizeNum(
            +this.$route.params.month + 1
          )}-01&end=${this.normalizeNum(
            this.$route.params.year
          )}-${this.normalizeNum(+this.$route.params.month + 2)}-01`
        )
        .then((response) => {
          for (let period of response.data) {
            this.getData(period);
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    async addPeriod() {
      await axios
        .post("http://localhost/api/periods/add.php", {
          employee_id: this.employee.id,
          status_id: this.status_id,
          start: this.start,
          end: this.hourly == 1 ? this.start : this.end,
          hours: this.hourly == 1 ? this.hours : null,
          shift_id: this.employee.shift_id,
        })
        .then(() => {
          this.update();
          this.closeAdd();
        })
        .catch((error) => {
          console.log(error);
        });
    },

    async updShift() {
      await axios
        .post("http://localhost/api/employees/updateShift.php", {
          id: this.employee.id,
          shift_id: this.shift_id,
        })
        .then(() => {
          this.getEmployee().then(() => {
            this.getShift();
            this.closeUpd();
          });
        })
        .catch((error) => {
          this.error = error.response.data.message;
        });
    },

    getData(period) {
      for (let status of this.statuses) {
        if (status.id == period.status_id) {
          let elem = [
            { id: "id", name: period.id, hidden: true },
            { id: "name", name: status.name },
            {
              id: "delete",
              delete: true,
              request: `http://localhost/api/periods/delete.php?id=${period.id}`,
            },
            { id: "start", name: period.start.split("-").reverse().join(".") },
            { id: "end", name: period.end.split("-").reverse().join(".") },
            { id: "hours", name: period.hours },
          ];
          this.data.push(elem);
          break;
        }
      }
    },

    normalizeNum(num) {
      if (num > 0 && num < 10) {
        return "0" + num;
      }

      return num;
    },

    showAdd() {
      this.modalAdd = true;
    },

    closeAdd() {
      this.status_id = this.statuses[0].id;
      this.start = "";
      this.end = "";
      this.hours = "";
      this.modalAdd = false;
    },

    showUpd() {
      this.modalUpd = true;
    },

    closeUpd() {
      this.shift_id = this.employee.shift_id;
      this.modalUpd = false;
    },

    update() {
      this.updated = true;
    },

    logout() {
      localStorage.removeItem("token");
      this.$router.push("/login");
    },
  },

  watch: {
    updated() {
      if (this.updated == true) {
        this.data = [];
        this.getPeriods();
        this.updated = false;
      }
    },

    status_id() {
      for (let status of this.statuses) {
        if (status.id == this.status_id) {
          this.hourly = status.hourly;
        }
      }
    },
  },
};
</script>

<style scoped>
.table-wrapper {
  width: max-content;
  max-width: 100%;
  margin-bottom: 20px;
}

.table {
  width: max-content;
  max-width: 100%;
}

.shift {
  display: flex;
  gap: 10px;
  align-items: center;
  margin-bottom: 20px;
}
</style>
