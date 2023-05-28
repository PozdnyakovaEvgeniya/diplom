<template>
  <div v-if="show" @click="close" class="blackout">
    <div class="modal">
      <slot></slot>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    show: Boolean,
  },

  data() {
    return {};
  },

  methods: {
    close(e) {
      if (e.target.className == "blackout") {
        this.$emit("close");
      }
    },
  },
};
</script>

<style scoped>
.blackout {
  width: 100vw;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  background: var(--blackout);
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 9;
}

.modal {
  box-shadow: 0 6px 15px var(--black);
  border-radius: 5px;
}
</style>
