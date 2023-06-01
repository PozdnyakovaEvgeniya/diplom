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
          <span>Начало</span>
          <input type="date" v-model="start" />
        </div>
        <div class="form-field">
          <span>Конец</span>
          <input type="date" v-model="end" />
        </div>
        <div class="form-button">
          <button>Добавить</button>
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
          <h4>{{ employee.name }}</h4>
          <div>{{ employee.job_title }}</div>
        </div>
      </div>
      <div class="content-header">
        <Add @click="showAdd">Добавить смену</Add>
      </div>
      <Table :headers="headers" :data="data"></Table>
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

export default {
  components: {
    Back,
    Multiselect,
    Add,
    Modal,
    Table,
  },

  data() {
    return {
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
      ],
      data: [],
    };
  },

  created() {
    this.getEmployee();
    this.getStatuses();
    this.getPeriods();
  },

  methods: {
    async getEmployee() {
      await axios
        .get(
          `http://localhost/api/employees/getOne.php?id=${this.$route.params.id}`
        )
        .then((response) => {
          this.employee = response.data;
        });
    },

    async getStatuses() {
      await axios
        .get("http://localhost/api/statuses/get.php")
        .then((response) => {
          this.statuses = response.data;
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
          end: this.end,
        })
        .then(() => {
          // this.update();
          this.closeAdd();
        })
        .catch((error) => {
          console.log(error);
        });
    },

    getData(period) {
      let elem = [
        { id: "id", name: period.id, hidden: true },
        { id: "name", name: period.status },
        {
          id: "delete",
          delete: true,
          // request: `http://localhost/api/shifts/delete.php?id=${shift.id}`,
        },
        { id: "start", name: period.start },
        { id: "end", name: period.end },
      ];
      this.data.push(elem);
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
      this.name = "";
      this.modalAdd = false;
    },
  },
};
</script>

<style scoped>
.employee {
  display: grid;
  gap: 10px;
}
</style>
