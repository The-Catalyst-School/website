<template>
  <div class="course-preview" :class="{'featured': (course.featured === 'yes')}">
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
          <div class="image-wrapper">

          </div>
          <div class="footer">
            <span v-if="course.teacher">
              With {{course.teacher}}
            </span>
          </div>
        </Link>
      </div>
    </div>
    <div class="read-more" @click="popupVisible = true">
      Read more about
    </div>
    <popup v-if="popupVisible" @close="popupVisible = false">
      <template v-slot:fixed-header>
        <div class="topics-wrapper">
          <div class="tag" :key="`topic-${topic.id}`" v-for="topic in course.topics">
            {{topic.title}}
          </div>
        </div>
        <div class="intro-heading">
          <div class="heading">
            <div class="date">{{ course.updated_at | dateFormat('DD.MM.YYYY') }}</div>
            <div class="teacher" v-if="course.teacher">With {{course.teacher}}</div>
            <div class="estimated" v-if="course.estimated_time">
              Estimated time: {{course.estimated_time}}
            </div>
          </div>
          <div class="title">
            <h1>
              <Link :href="$route('web.course.show', course.slug)">
                {{course.title}}
              </Link>
            </h1>
          </div>
        </div>
      </template>
      <template v-slot:scrollable>
        <course-intro :course="course" />
      </template>
    </popup>
  </div>
</template>

<script>

import { Link } from '@inertiajs/inertia-vue'
import Popup from './Popup';
import CourseIntro from './CourseIntro';

export default {
  props: ['course'],
  components: {
    Link,
    Popup,
    CourseIntro
  },
  data() {
    return {
      popupVisible: false
    }
  }
};
</script>

<style lang="scss" scoped>
@use 'sass:math';
@import '../../sass/_mixins';
@import '../../sass/_variables';
.course-preview {
  @include col(4 of 14);
  @include r('margin-bottom', 20px);
  display: flex;
  flex-direction: column;
  @include mobile-tablet {
    @include col(1 of 1);
  }
  &.featured {
    @include col(6 of 14);
    @include mobile-tablet {
      @include col(1 of 1);
    }
  }
  .main-body {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    .topics-wrapper {
      display: flex;
      flex-wrap: wrap;
      .tag {
        @include transition('background, color');
        @include r('margin-bottom', 6px);
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
    &:hover {
      background: $black;
      color: $yellow;
    }
  }
  .popup {
    .topics-wrapper {
      position: absolute;
      bottom: 100%;
      left: 0;
      display: flex;
      flex-wrap: wrap;
      @include r('margin-bottom', 6px);
      .tag {
        background: $white;
      }
    }
    .intro-heading {
      @include col(8 of 10);
      @include col-before(1 of 10);
      .heading {
        display: flex;
        justify-content: space-between;
        .date {
          @include col(2 of 8, 0);
        }
        .teacher {
          @include col(4 of 8);
        }
      }
    }
  }
  &.featured {
    .main-body .preview-body .image-wrapper {
      padding-top: 50%;
    }
  }
}
</style>
