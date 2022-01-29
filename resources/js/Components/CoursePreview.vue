<template>
  <div class="course-preview">
    <div class="main-body">
      <div class="topics-wrapper">
        <div class="tag">Topic</div>
        <div class="tag">Beginner level</div>
        <div class="tag">4 lessons</div>
      </div>
      <div class="preview-body">
        <Link :href="$route('web.course.show', course.slug)">
          <div class="heading">
            <div class="date">{{ course.updated_at | dateFormat('DD.MM.YYYY') }}</div>
            <div class="estimated">Estimated time: 3h 25m</div>
          </div>
          <div class="title">
            <h2>
                {{course.title}}
            </h2>
          </div>
          <div class="image-wrapper">

          </div>
          <div class="footer">
            With Teacher Name
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
          <div class="tag">Topic</div>
          <div class="tag">Beginner level</div>
          <div class="tag">4 lessons</div>
        </div>
        <div class="intro-heading">
          <div class="heading">
            <div class="date">{{ course.updated_at | dateFormat('DD.MM.YYYY') }}</div>
            <div class="teacher">With Teacher Name</div>
            <div class="estimated">Estimated time: 3h 25m</div>
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
  .main-body {
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
      @include default-spacing;
      @include transition('background');
      a, a:visited {
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
}
</style>
