<template>
  <div class="employee_page">
    <Modal :show="modalAdd" @close="closeAdd">
      <form class="form" @submit.prevent="">
        <h4>Добавить период</h4>
        <div class="error">{{ error }}</div>
        <div class="form-field">
          <span>Название периода</span>
          <Multiselect
            v-model="status"
            label="name"
            trackBy="id"
            valueProp="id"
            :options="statuses"
          ></Multiselect>
        </div>
        <div class="form-field">
          <span>Начало</span>
          <input type="text" name="start" />
        </div>
        <div class="form-field">
          <span>Конец</span>
          <input type="text" name="end" />
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
      <Table></Table>
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
      status: "",
      modalAdd: false,
    };
  },

  created() {
    this.getEmployee();
    this.getStatuses();
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
          console.log(this.statuses);
        });
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
