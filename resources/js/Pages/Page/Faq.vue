<template>
  <div>
    <section class="faqs">
      <h4 class="section-title">Frequently Asked Questions</h4>
      <faqs :faqs="page.sentences" :closable="true" />
    </section>
  </div>
</template>

<script>

import { Link } from '@inertiajs/inertia-vue'
import Faqs from '../../Components/Faqs';
export default {
  props: ['page'],
  components: {
    Link,
    Faqs
  },
  data() {
    return {
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
}
</style>
