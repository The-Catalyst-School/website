<template>
  <div class="internal-faq">
    <div class="question">
      <div class="counter">{{faq.idx}}</div>
      <div class="q"><h2 v-html="faq.question"></h2></div>
      <div class="btn-wrapper on-desktop">
        <div v-if="closable"
          class="btn"
          @click="$emit('toggle', faq.idx)">{{msg}}</div>
      </div>
      <div class="btn-wrapper on-mobile">
        <div class="btn active with-image"
          v-if="closable"
          @click="$emit('toggle', faq.idx)">
          <img src="/images/plus.svg" v-if="!active" />
          <img src="/images/minus.svg" v-if="active" />
        </div>
      </div>
    </div>
    <slide-up-down
      class="answer" :active="active" :duration="500">
      <div class="wrapper" v-html="faq.answer"></div>
    </slide-up-down>
  </div>
</template>

<script>
export default {
  props: ['current', 'faq', 'closable'],
  computed: {
    active() {
      if (this.closable) {
        return (this.faq.idx === this.current)
      }
      return true
    },
    msg() {
      return (this.active) ? 'close' : 'Learn more about'
    }
  }
};
</script>

<style lang="scss" scoped>
@use 'sass:math';
@import '../../sass/_mixins';
@import '../../sass/_variables';
.internal-faq {
  .question {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    .counter {
      @include r('width', 24px);
      @include r('height', 24px);
      border-radius: 100%;
      background: $black;
      color: $yellow;
      display: flex;
      justify-content: center;
      align-items: center;
      @include mobile-tablet {
        width: 28px;
        height: 28px;
      }
    }
    .q {
      flex-grow: 1;
      @include r('padding-left', 10px);
      width: calc(80% - #{relative-size(24px)});
      h2 {
        text-transform: initial;
        font-weight: normal;
        strong {
          font-weight: normal;
        }
      }
    }
    .btn-wrapper {
      @include col(2 of 10, 0);
      display: flex;
      justify-content: flex-end;
      @include mobile-tablet {
        &.on-mobile {
          @include r('width', 28px);
          display: flex !important;
        }
      }
    }
  }
  .answer {
    @include m-font-size(20, 26);
    @include mobile-tablet {
      @include font-size(14, 17);
    }
    .wrapper {
      @include r('padding-left', 34px);
      @include r('padding-top', 20px);
      @include mobile-tablet {
        padding-top: 5px;
        padding-bottom: 15px;
      }
    }
  }
}
</style>
