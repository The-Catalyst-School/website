<template>
  <div class="event-preview"
    v-click-outside="onClickOutside"
    :class="[eventType, active ? 'active' : '', event.special ? 'special' : '']">
    <div class="label" @click="active = !active">{{label}}</div>
    <div class="info">
      <div class="internal">
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
          <a :href="event.link" target="_blank">Link to event</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['event'],
  data() {
    return {
      active: false
    }
  },
  computed: {
    label() {
      if (this.eventType === 'workshop') {
        return 'w'
      }
      if (this.event.special) {
        return '!'
      }
      if (this.event.short_title) {
        return this.event.short_title
      }
      return 'Event'
    },
    eventType() {
      if (!this.event.type) {
        return 'generic'
      }
      return this.event.type
    }
  },
  methods: {
    onClickOutside() {
      this.active = false
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
  @include r('margin-right', 6px);
  &.workshop, &.special {
    @include r('width', 24px);
    @include r('height', 24px);
    .label {
      @include r('padding', 4.5px 0);
    }
  }
  .label {
    background: $black;
    color: $yellow;
    text-transform: uppercase;
    @include r('padding', 4.5px 9px);
    @include r('border-radius', 12px);
    cursor: pointer;
    text-align: center;
  }
  .info {
    position: absolute;
    top: 0;
    left: calc(100% + #{relative-size(6)});
    background: $black;
    color: $yellow;
    @include r('border-radius', 12px);
    display: flex;
    flex-direction: column;
    width: 0;
    pointer-events: none;
    z-index: 2;
    @include transition('width, opacity');
    overflow: hidden;
    .internal {
      @include col-vw(2.5 of 14);
      @include r('padding', 9px 15px);
    }
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
  &.active {
    .info {
      opacity: 1;
      @include col-vw(2.5 of 14);
      padding-left: 0;
      padding-right: 0;
      pointer-events: initial;
    }
  }
}
</style>
