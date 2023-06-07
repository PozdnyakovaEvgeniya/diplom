<template>
  <button>
    <svg
      class="icon"
      height="72"
      id="svg1025"
      version="1.1"
      viewBox="0 0 19.05 19.050001"
      width="72"
      xmlns="http://www.w3.org/2000/svg"
      xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
      xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
      xmlns:svg="http://www.w3.org/2000/svg"
    >
      <defs id="defs1022" />
      <g id="layer1" style="opacity: 1">
        <path
          d="m 14.765708,1.9170698 -1.224649,1.2245979 a 0.16840163,0.16840163 89.999953 0 0 0,0.238161 l 2.191908,2.1918086 a 0.10001956,0.10001956 179.99995 0 0 0.141446,-1e-7 l 1.224649,-1.224598 a 0.16840162,0.16840162 89.999951 0 0 0,-0.238161 L 14.907154,1.9170697 a 0.10001956,0.10001956 179.99995 0 0 -0.141446,10e-8 z M 12.736676,3.946032 2.2207483,14.461515 A 0.3669443,0.3669443 115.20187 0 0 2.1148974,14.68644 l -0.21077,2.228661 a 0.22447021,0.22447021 45.000468 0 0 0.2446038,0.244607 L 4.3471904,16.951831 A 0.45156567,0.45156567 154.79984 0 0 4.6239798,16.821583 L 15.115348,6.330681 a 0.19014953,0.19014953 89.999961 0 0 0,-0.2689182 L 12.999517,3.9460317 a 0.18586087,0.18586087 179.99993 0 0 -0.262841,3e-7 z"
          id="path1040"
          style="
            font-variation-settings: normal;
            fill: none;
            fill-opacity: 1;
            stroke-width: 1;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-miterlimit: 4;
            stroke-dasharray: none;
            stroke-dashoffset: 0;
            stroke-opacity: 1;
            paint-order: markers fill stroke;
            stop-color: #000000;
          "
        />
      </g>
    </svg>
    <slot></slot>
  </button>
</template>

<script>
export default {
  data() {
    return {
      data: {},
    };
  },

  methods: {},
};
</script>

<style scoped>
.icon {
  width: 18px;
  height: 18px;
  stroke: var(--darkgrey);
  fill: var(--darkgrey);
}

button {
  justify-content: center;
}

button {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 5px;
  background: none;
  color: var(--darkgrey);
  padding: 10px 20px;
}

button:hover {
  color: var(--black);
}

button:hover .icon {
  fill: var(--black);
  stroke: var(--black);
}
</style>
