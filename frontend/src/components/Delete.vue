<template>
  <Modal :show="modalConfirm" @close="closeConfirm">
    <form class="form" @submit.prevent="submit">
      <div class="form-field">Вы уверены?</div>
      <div v-if="error" class="error">{{ error }}</div>
      <div class="form-button">
        <button>Удалить</button>
        <button type="button" @click="closeConfirm">Отменить</button>
      </div>
    </form>
  </Modal>
  <button class="delete" @click="showConfirm">
    <svg
      class="icon"
      height="22"
      style="enable-background: new 0 0 512 512"
      version="1.1"
      viewBox="0 0 512 512"
      width="22"
      xml:space="preserve"
      xmlns="http://www.w3.org/2000/svg"
      xmlns:xlink="http://www.w3.org/1999/xlink"
    >
      <g class="st2" id="cross">
        <g class="st0">
          <line class="st1" x1="112.5" x2="401" y1="112.5" y2="401" />
          <line class="st1" x1="401" x2="112.5" y1="112.5" y2="401" />
        </g>
      </g>
      <g id="cross_copy">
        <path
          d="M268.064,256.75l138.593-138.593c3.124-3.124,3.124-8.189,0-11.313c-3.125-3.124-8.189-3.124-11.314,0L256.75,245.436   L118.157,106.843c-3.124-3.124-8.189-3.124-11.313,0c-3.125,3.124-3.125,8.189,0,11.313L245.436,256.75L106.843,395.343   c-3.125,3.125-3.125,8.189,0,11.314c1.562,1.562,3.609,2.343,5.657,2.343s4.095-0.781,5.657-2.343L256.75,268.064l138.593,138.593   c1.563,1.562,3.609,2.343,5.657,2.343s4.095-0.781,5.657-2.343c3.124-3.125,3.124-8.189,0-11.314L268.064,256.75z"
        />
      </g>
    </svg>
  </button>
</template>

<script>
import axios from "axios";
import Modal from "@/components/Modal.vue";

export default {
  components: {
    Modal,
  },

  props: {
    request: String,
  },

  data() {
    return {
      modalConfirm: false,
    };
  },

  methods: {
    async submit() {
      await axios.get(this.request).then(() => {
        this.$emit("update");
      });
    },

    showConfirm() {
      this.modalConfirm = true;
    },

    closeConfirm() {
      this.error = "";
      this.modalConfirm = false;
    },
  },
};
</script>

<style scoped>
.icon {
  width: 18px;
  height: 18px;
  fill: var(--white);
}

.delete {
  padding: 0;
  width: 23px;
  height: 23px;
  border-radius: 5px;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>
