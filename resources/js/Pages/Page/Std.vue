<template>
  <div class="std-page">
    <div class="side affix">
    </div>
    <div class="main">
      <h1>{{page.title}}</h1>
      <div id="content" class="html-content" v-html="page.content"></div>
    </div>
    <div class="side affix">
    </div>
  </div>
</template>

<script>

export default {
  props: ['page']
};
</script>

<style lang="scss" scoped>
  @import '../../../sass/_mixins';
  @import '../../../sass/_variables';
  .std-page {
    @include r('padding', 20px 30px);
    display: flex;
    @include mobile-tablet {
      padding: 20px 10px;
    }
    .side {
      @include col(2 of 14);
      @include mobile-tablet {
        display: none;
      }
    }
    .main {
      @include col(10 of 14, 0);
      @include mobile-tablet {
        @include col(1 of 1, 0);
      }
      & > h4 {
        @include col(1 of 1);
      }
      & > h1 {
        @include col(1 of 1);
        @include r('margin-bottom', 8px);
      }
    }
  }
</style>
