<template>
  <div class="faqs-list">
    <div class="single-faq"
      :key="`faq-${faq.idx}`"
      v-for="faq in faqs">
      <question :faq="faq"
        :current="current"
        :closable="closable"
        @toggle="handleToggle" />
    </div>
  </div>
</template>

<script>

import { Link } from '@inertiajs/inertia-vue'
import Question from './Question';
export default {
  props: ['faqs', 'closable'],
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
@import '../../sass/_mixins';
@import '../../sass/_variables';
.faqs-list {
  @include col(10 of 14);
  @include col-before(2 of 14);
  @include col-after(2 of 14);
  @include mobile-tablet {
    @include col(1 of 1);
    margin-left: 0;
    margin-right: 0;
  }
  .single-faq {
    border-bottom: 1px solid $black;
    @include r('padding-top', 8px);
    @include r('padding-bottom', 8px);
    &:first-child {
      border-top: 1px solid $black;
    }
  }
}
</style>
