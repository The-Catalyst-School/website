<template>
  <div class="slider">
    <div class="track">
      <div class="track-content">
        <slot name="track"></slot>
      </div>
      <div class="more">
        <slot name="more"></slot>
      </div>
    </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
@use 'sass:math';
@import '../../sass/_mixins';
@import '../../sass/_variables';
.slider {
  width: 100%;
  .track {
    @include col(14 of 14);
    padding-left: math.div(100%, 14) * 2;
    overflow: auto;
    display: flex;
    align-items: stretch;
    .track-content {
      display: flex;
      & > div {
        @include col-vw(4 of 14);
        &.featured {
          @include col-vw(6 of 14);
        }
      }
    }
    .more {
      @include col-vw(1 of 12);
      text-transform: uppercase;
      display: flex;
      justify-content: center;
      flex-direction: column;
      white-space: nowrap;
    }
  }
}
</style>
