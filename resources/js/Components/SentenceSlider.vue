<template>
  <div class="sentence-slider">
    <transition-group name="fade" tag="div">
      <div class="sentence-slide"
        :key="`sentence-${sentence.idx}`"
        v-for="sentence in currentSlides">
        <div class="internal-wrapper">
          <h1>{{sentence.text}}</h1>
          <p class="link"><Link :href="sentence.link">Continue to read</Link></p>
        </div>
      </div>
    </transition-group>
    <div class="sentence-slide placeholder">
      <div class="internal-wrapper">
        <h1>{{biggerSlide.text}}</h1>
        <p class="link"><Link :href="biggerSlide.link">Continue to read</Link></p>
      </div>
    </div>
  </div>
</template>

<script>

import { Link } from '@inertiajs/inertia-vue'

export default {
  props: ['sentences'],
  data() {
    return {
      current: 0,
      interval: false
    }
  },
  components: {
    Link,
  },
  computed: {
    currentSlides() {
      return this.sentences.filter((el, idx) => idx === this.current)
    },
    biggerSlide() {
      const maxLength = Math.max(...this.sentences.map(item => item.text.length))
      return this.sentences.find((el) => el.text.length === maxLength)
    }
  },
  methods: {
    changeSlide() {
      let newCurrent = this.current + 1
      if (newCurrent >= this.sentences.length) {
        newCurrent = 0
      }
      this.current = newCurrent
    }
  },
  mounted() {
    this.interval = setInterval(this.changeSlide, 5000)
    this.changeSlide()
  }
};
</script>

<style lang="scss">
@use 'sass:math';
@import '../../sass/_mixins';
@import '../../sass/_variables';
.sentence-slider {
  @include col(12 of 14);
  @include col-after(2 of 14);
  position: relative;
  .sentence-slide {
    position: absolute;
    top: 0;
    left: 0;
    @include col(1 of 1);
    .internal-wrapper {
      position: relative;
      h1 {
        text-transform: initial;
      }
      .link {
        text-transform: uppercase;
        position: absolute;
        bottom: 0;
        right: 0;
      }
    }
    &.placeholder {
      position: relative;
      opacity: 0;
      padding: 0;
    }
  }
  .fade-enter-active, .fade-leave-active {
    transition: opacity 5s;
  }
  .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
  }
}
</style>
