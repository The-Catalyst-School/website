<template>
  <div class="popup">
    <div class="bkg" @click="$emit('close')">&nbsp;</div>
    <div class="wrapper">
      <div class="fixed-header">
        <slot name="fixed-header"></slot>
      </div>
      <div class="scrollable">
        <slot name="scrollable"></slot>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
@use 'sass:math';
@import '../../sass/_mixins';
@import '../../sass/_variables';
.popup {
  position: fixed;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  .bkg {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 0;
    background: rgba(0,0,0,0.3);
    cursor: pointer;
  }
  .wrapper {
    @include col(10 of 14, 0);
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translateX(-50%) translateY(-50%);
    background: $white;
    border: 1px solid $black;
    z-index: 1;
    .scrollable {
      max-height: 80vh;
      overflow: auto;
    }
    .fixed-header {
      top: 0;
      left: 0;
      width: 100%;
      position: absolute;
      @include r('padding-top', 8px);
    }
  }
}
</style>
