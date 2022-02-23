<template>
  <div class="course-intro">
    <div class="body">
      <div class="image-wrapper">
      </div>
      <div class="html-content" v-html="course.content"></div>
      <section class="lessons-list" v-if="course.lessons">
        <lessons :course="course" :lessons="course.lessons"></lessons>
      </section>
      <section class="students-list" v-if="course.students">
        <h3 class="section">Students of this course</h3>
      </section>
      <section class="comments-list" v-if="course.comments">
        <h3 class="section">Some comments about</h3>
      </section>
    </div>
  </div>
</template>

<script>

import { Link } from '@inertiajs/inertia-vue'
import Lessons from './Lessons';

export default {
  props: ['course'],
  components: {
    Link,
    Lessons
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
    @include col(8 of 10, 0);
    @include col-before(1 of 10);
    @include r('padding-top', 70px);
    @include r('padding-bottom', 120px);
    .html-content {
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
      h2, h3, h4 {
        @include col(2 of 8);
        clear: left;
        float: left;
        transform: translateY(#{relative-size(4px)});
        @include mobile-tablet {
          @include col(1 of 1);
        }
      }
      h2 {
        font-weight: 600;
        text-transform: initial;
      }
      p,
      ul,
      ol,
      .hint,
      blockquote,
      .embed-responsive,
      table,
      .file,
      .tabs {
        @include col(6 of 8);
        float: left;
        @include mobile-tablet {
          @include font-size(18, 23);
          @include col(1 of 1);
          margin-bottom: 15px;
        }
        & + p,
        & + ul,
        & + ol,
        & + .hint,
        & + blockquote,
        & + .embed-responsive,
        & + table,
        & + .file,
        & + .tabs {
          @include col-before(2 of 8);
          @include mobile-tablet {
            margin-left: 0;
            margin-bottom: 15px;
          }
        }
      }
      h1:first-child {
        display: none;
      }
      .hint.is-info {
        display: none;
      }
    }
    section {
      @include col(1 of 1, 0);
      @include r('margin-bottom', 70px);
      h3 {
        @include m-font-size(14, 17);
        @include r('margin-bottom', 15px);
      }
    }
  }
}
</style>
