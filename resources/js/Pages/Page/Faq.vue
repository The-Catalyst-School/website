<template>
  <div>
    <section class="faqs">
      <h4 class="section-title">Frequently Asked Questions</h4>
      <div class="faqs-list">
        <div class="single-faq"
          :key="`faq-${faq.idx}`"
          v-for="faq in page.sentences">
          <question :faq="faq" :current="current" @toggle="handleToggle" />
        </div>
      </div>
    </section>
  </div>
</template>

<script>

import { Link } from '@inertiajs/inertia-vue'
import Question from '../../Components/Question';
export default {
  props: ['page'],
  components: {
    Link,
    Question
  },
  data() {
    return {
      current: -1
    }
  },
  methods: {
    handleToggle(idx) {
      if (idx === this.current) {
        this.current = -1
      } else {
        this.current = idx
      }
    }
  }
};
</script>

<style lang="scss" scoped>
@use 'sass:math';
@import '../../../sass/_mixins';
@import '../../../sass/_variables';
section {
  @include r('padding', 20px 30px);
  @include r('margin-bottom', 130px);
  .section-title {
    @include col(10 of 14);
    @include col-before(2 of 14);
    @include col-after(2 of 14);
    @include r('margin-bottom', 10px);
  }
  .faqs-list {
    @include col(10 of 14);
    @include col-before(2 of 14);
    @include col-after(2 of 14);
    .single-faq {
      border-bottom: 1px solid $black;
      @include r('padding-top', 8px);
      @include r('padding-bottom', 8px);
      &:first-child {
        border-top: 1px solid $black;
      }
    }
  }
}
</style>
