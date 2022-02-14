<template>
  <div class="course-preview">
    <div class="main-body">
      <div class="topics-wrapper">
        <div class="tag" :key="`topic-${topic.id}`" v-for="topic in course.topics">
          {{topic.title}}
        </div>
      </div>
      <div class="preview-body">
        <Link :href="$route('web.course.show', course.slug)">
          <div class="heading">
            <div class="date">{{ course.updated_at | dateFormat('DD.MM.YYYY') }}</div>
            <div class="estimated" v-if="course.estimated_time">
              Estimated time: {{course.estimated_time}}
            </div>
          </div>
          <div class="title">
            <h2>{{course.title}}</h2>
          </div>
          <div class="subtitle" v-if="course.subtitle">
            <h2>{{course.subtitle}}</h2>
          </div>
          <div class="footer">
            <span v-if="course.teacher">
              With {{course.teacher}}
            </span>
          </div>
        </Link>
      </div>
    </div>
    <div class="read-more">
      <div class="bkg" :style="{width: `${progress}%`}">
      Progress: {{progress}}%
      </div>
      Progress: {{progress}}%
    </div>
  </div>
</template>

<script>

import { Link } from '@inertiajs/inertia-vue'

export default {
  props: ['course'],
  components: {
    Link,
  },
  data() {
    return {
    }
  },
  computed: {
    progress() {
      return parseInt((this.course.countLessons * 100) / this.course.tot_lessons);
    }
  }
};
</script>

<style lang="scss" scoped>
@use 'sass:math';
@import '../../sass/_mixins';
@import '../../sass/_variables';
.course-preview {
  @include col(1 of 1);
  @include r('margin-bottom', 20);
  display: flex;
  flex-direction: column;
  height: 100%;
  .main-body {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    .topics-wrapper {
      display: flex;
      flex-wrap: wrap;
      @include r('margin-bottom', 6px);
      .tag {
        @include transition('background, color');
      }
    }
    .preview-body {
      border: 1px solid $black;
      flex-grow: 1;
      @include default-spacing;
      @include transition('background');
      a, a:visited {
        display: flex;
        flex-direction: column;
        height: 100%;
        @include transition('color');
      }
      .heading {
        display: flex;
        justify-content: space-between;
      }
      .title {
        text-decoration: underline;
      }
      .image-wrapper {
        width: 100%;
        padding-top: 73%;
      }
      .footer {
        flex-grow: 1;
        display: flex;
        align-items: flex-end;
      }
    }
    &:hover {
      .preview-body {
        background: $black;
      }
      .topics-wrapper {
        .tag {
          background: $black;
          color: $yellow;
        }
      }
      a, a:visited {
        color: $yellow;
      }
    }
  }
  .read-more {
    width: 100%;
    display: block;
    @include default-spacing;
    text-transform: uppercase;
    border-bottom: 1px solid $black;
    border-left: 1px solid $black;
    border-right: 1px solid $black;
    cursor: pointer;
    @include transition('background, color');
    position: relative;
    .bkg {
      position: absolute;
      top: 0;
      left: 0;
      height: 100%;
      @include default-spacing;
      background: $black;
      overflow: hidden;
      word-break: keep-all;
      white-space: nowrap;
      color: $yellow;
    }
  }
}
</style>
