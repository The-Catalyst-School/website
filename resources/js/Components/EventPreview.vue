<template>
  <div class="event-preview">
    <div class="label">Event</div>
    <div class="info">
      <div class="heading">
        <div class="date">{{event.scheduled_at | dateFormat('DD.MM.YYYY')}}</div>
        <div class="time">{{event.scheduled_at | dateFormat('HH:mm')}}</div>
      </div>
      <div class="title">
        <h2>{{event.title}}</h2>
      </div>
      <div class="description">
        <p>About</p>
        <p class="text">{{event.description}}</p>
      </div>
      <div class="link">
        <a :href="event.link" target="_blank">Link</a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['event'],
  computed: {
    active() {
      return true
    }
  }
};
</script>

<style lang="scss" scoped>
@use 'sass:math';
@import '../../sass/_mixins';
@import '../../sass/_variables';
.event-preview {
  position: relative;
  .label {
    background: $black;
    color: $yellow;
    text-transform: uppercase;
    @include r('padding', 4.5px 9px);
    @include r('border-radius', 12px);
    @include r('margin-right', 6px);
    cursor: pointer;
  }
  .info {
    position: absolute;
    top: 0;
    left: 100%;
    background: $black;
    color: $yellow;
    @include r('padding', 9px 15px);
    @include r('border-radius', 12px);
    display: flex;
    flex-direction: column;
    @include col-vw(2.5 of 14);
    opacity: 0;
    pointer-events: none;
    z-index: 2;
    a, a:visited {
      color: $yellow;
    }
    .heading {
      @include r('margin-bottom', 5);
      display: flex;
      justify-content: space-between;
    }
    .title {
      @include r('margin-bottom', 30);
    }
    .description {
      @include r('margin-bottom', 30);
      .text {
        @include m-font-size(20, 27);
      }
    }
  }
  &:hover {
    .info {
      opacity: 1;
      pointer-events: initial;
    }
  }
}
</style>
