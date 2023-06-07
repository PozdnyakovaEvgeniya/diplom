<template>
  <button :class="class">
    <svg
      class="icon"
      xmlns="http://www.w3.org/2000/svg"
      xmlns:xlink="http://www.w3.org/1999/xlink"
      version="1.1"
      id="Layer_1"
      x="0px"
      y="0px"
      viewBox="0 0 512 512"
      style="enable-background: new 0 0 512 512"
      xml:space="preserve"
    >
      <g>
        <g>
          <path
            d="M256,0c-11.422,0-20.682,9.26-20.682,20.682v470.636c0,11.423,9.26,20.682,20.682,20.682    c11.423,0,20.682-9.259,20.682-20.682V20.682C276.682,9.26,267.423,0,256,0z"
          />
        </g>
      </g>
      <g>
        <g>
          <path
            d="M491.318,235.318H20.682C9.26,235.318,0,244.578,0,256c0,11.423,9.26,20.682,20.682,20.682h470.636    c11.423,0,20.682-9.259,20.682-20.682C512,244.578,502.741,235.318,491.318,235.318z"
          />
        </g>
      </g>
    </svg>
    <slot></slot>
  </button>
</template>

<script>
export default {
  props: { class: String },
};
</script>

<style scoped>
.icon {
  width: 11px;
  height: 11px;
  stroke: var(--white);
  fill: var(--white);
}

button {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 5px;
}

button.link {
  background: none;
  color: initial;
  font-size: 14px;
  width: 100%;
  padding: 10px 20px;
  justify-content: flex-start;
  border-bottom: 1px solid var(--purple);
  border-top: 1px solid var(--purple);
}

button.link:hover {
  background: var(--white);
}

button.link .icon {
  fill: initial;
}
</style>
