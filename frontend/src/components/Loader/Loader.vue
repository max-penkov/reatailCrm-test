<template lang="pug">
  .data-loader(v-if="show" :class="{ 'data-loader--single' : isCustom }")
    i.la.la-spinner.la-spin(v-bind:style="{fontSize: size + 'px'}")
</template>

<script>
export default {
  name: 'Loader',
  props: {
    size: {
      type: Number,
      default: 21
    },
    show: {
      type: Boolean,
      default: false,
    },
    isCustom: {
      type: Boolean,
      default: false,
    },
  }
}
</script>

<style src="./Loader.scss" lang="scss"/>
