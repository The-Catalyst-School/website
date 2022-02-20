<template>
  <div class="slider">
    <div class="track"
      v-dragscroll
      @dragscrollstart="onDragStart"
      @click.capture="onDragClick">
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

<script>
export default {
  data: () => ({
    dragged: false,
    dragTimeout: null,
  }),
  methods: {
    onDragStart() {
      clearTimeout(this.dragTimeout);

      this.dragged = false;
      this.dragTimeout = setTimeout(() => { this.dragged = true; }, 100); // Minimal delay to be regarded as drag instead of click
    },
    onDragClick(e) {
      if (this.dragged) {
        e.preventDefault();
      }

      this.dragged = false;
    },
  },
};
</script>

<style lang="scss" scoped>
@use 'sass:math';
@import '../../sass/_mixins';
@import '../../sass/_variables';
.slider {
  width: 100%;
  .track {
    @include col(14 of 14);
    padding-left: math.div(100%, 14) * 2;
    overflow: hidden;
    display: flex;
    align-items: stretch;
    .track-content {
      display: flex;
      & > div {
        @include col-vw(4 of 14);
        @include mobile-tablet {
          @include col-vw(0.90 of 1);
        }
        &.featured {
          @include col-vw(6 of 14);
          @include mobile-tablet {
            @include col-vw(0.90 of 1);
          }
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
