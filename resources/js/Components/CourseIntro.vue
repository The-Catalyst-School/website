<template>
  <div class="course-intro">
    <div class="body">
      <div class="image-wrapper">
      </div>
      <div class="content" v-html="course.content"></div>
      <section class="lessons-list">
        <h3 class="section">Lessons overview</h3>
      </section>
      <section class="students-list">
        <h3 class="section">Students of this course</h3>
      </section>
      <section class="comments-list">
        <h3 class="section">Some comments about</h3>
      </section>
    </div>
  </div>
</template>

<script>

import { Link } from '@inertiajs/inertia-vue'

export default {
  props: ['course'],
  components: {
    Link,
  }
};
</script>

<style lang="scss">
@use 'sass:math';
@import '../../sass/_mixins';
@import '../../sass/_variables';
.course-intro {
  width: 100%;
  float: left;
  .body {
    @include col(8 of 10);
    @include col-before(1 of 10);
    @include r('padding-top', 70px);
    @include r('padding-bottom', 120px);
    .content {
      display: flex;
      flex-wrap: wrap;
      @include r('margin-bottom', 70px);
      hr:first-child {
        display: none;
        & + h2 {
          display: none;
          & + h1 {
            display: none;
          }
        }
      }
      h2 {
        @include m-font-size(12, 15);
        @include col(2 of 8, 0);
        text-transform: initial;
      }
      p {
        @include m-font-size(20, 26);
        @include col(6 of 8);
      }
      .hint.is-info {
        display: none;
      }
    }
    section {
      @include col(1 of 1, 0);
      @include r('margin-bottom', 70px);
      h3 {
        @include m-font-size(12, 15);
      }
    }
  }
}
</style>
